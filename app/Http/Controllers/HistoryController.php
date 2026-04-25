<?php
// app/Http/Controllers/HistoryController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Treatment;
use App\Models\Client;

class HistoryController extends Controller
{
    public function index()
    {
        $pets = Pet::with(['client', 'breed'])
            ->orderBy('name')
            ->get();
        
        $treatments = Treatment::all();
        
        return view('history.index', compact('pets', 'treatments'));
    }

    public function client($code = null)
    {

        $client_id = Client::where('access_code', $code)->pluck('id');
        $pets = Pet::with(['client', 'breed'])
            ->where('client_id', $client_id)
            ->orderBy('name')
            ->get();
        
        $treatments = Treatment::all();
        
        return view('history.index', [
            'pets' => $pets,
            'treatments' => $treatments,
            'code' => $code
        ]);
    }
    
    public function getPetHistory($petId)
    {
        $appointments = Appointment::with(['pet', 'treatments'])
            ->where('pet_id', $petId)
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        return response()->json([
            'appointments' => $appointments->map(function($appointment) {
                return [
                    'id' => $appointment->id,
                    'date' => $appointment->appointment_date->format('d/m/Y'),
                    'time' => $appointment->appointment_date->format('g:i A'),
                    'status' => $appointment->status,
                    'price' => number_format($appointment->price, 0, ',', '.'),
                    'observations' => $appointment->observations,
                    'treatments' => $appointment->treatments->map(function($t) {
                        return [
                            'id' => $t->id,
                            'name' => $t->name
                        ];
                    }),
                    'checkin_time' => $appointment->checkin_time ? Carbon::parse($appointment->checkin_time)->format('d/m/Y g:i A') : null,
                    'checkin_photo' => $appointment->checkin_photo ? asset('storage/' . $appointment->checkin_photo) : null,
                    'checkin_observations' => $appointment->checkin_observations,
                    'process_photo' => $appointment->process_photo ? asset('storage/' . $appointment->process_photo) : null,
                    'process_observations' => $appointment->process_observations,
                    'checkout_time' => $appointment->checkout_time ? Carbon::parse($appointment->checkout_time)->format('d/m/Y g:i A') : null,
                    'checkout_photo' => $appointment->checkout_photo ? asset('storage/' . $appointment->checkout_photo) : null,
                    'checkout_observations' => $appointment->checkout_observations,
                ];
            })
        ]);
    }
    
    // Registrar llegada (checkin)
    public function registerCheckin(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'checkin_photo' => 'nullable|image|max:2048',
            'checkin_observations' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();
            
            $appointment = Appointment::findOrFail($request->appointment_id);
            
            if ($appointment->checkin_time) {
                throw new \Exception('Ya se registró la llegada de esta mascota');
            }
            
            $appointment->checkin_time = now();
            $appointment->checkin_observations = $request->checkin_observations;
            $appointment->status = 'En proceso';
            
            if ($request->hasFile('checkin_photo')) {
                $file = $request->file('checkin_photo');
                $filename = 'checkin_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                            . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('appointments/checkin', $filename, 'public');
                $appointment->checkin_photo = $path;
            }
            
            $appointment->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Llegada registrada exitosamente',
                'checkin_time' => $appointment->checkin_time->format('d/m/Y g:i A'),
                'status' => $appointment->status
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
    
    // Registrar foto durante el proceso
    public function registerProcess(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'process_photo' => 'nullable|image|max:2048',
            'process_observations' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();
            
            $appointment = Appointment::findOrFail($request->appointment_id);
            
            if (!$appointment->checkin_time) {
                throw new \Exception('Debes registrar la llegada primero');
            }
            
            if ($request->hasFile('process_photo')) {
                $file = $request->file('process_photo');
                $filename = 'process_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                            . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('appointments/process', $filename, 'public');
                $appointment->process_photo = $path;
            }
            
            $appointment->process_observations = $request->process_observations;
            $appointment->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Foto del proceso registrada exitosamente',
                'process_photo' => $appointment->process_photo ? asset('storage/' . $appointment->process_photo) : null
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
    
    // Registrar salida/completado
    public function registerCheckout(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'treatment_id' => 'required|min:1',
            'price' => 'required|numeric|min:0', // Usamos price en lugar de final_price
            'checkout_observations' => 'nullable|string|max:500',
            'checkout_photo' => 'nullable|image|max:2048' // Foto de salida
        ]);

        try {
            DB::beginTransaction();
            
            $appointment = Appointment::findOrFail($request->appointment_id);
            
            if (!$appointment->checkin_time) {
                throw new \Exception('Debes registrar la llegada primero');
            }
            
            if ($appointment->checkout_time) {
                throw new \Exception('Esta cita ya fue completada');
            }
            
            $appointment->checkout_time = now();
            $appointment->checkout_observations = $request->checkout_observations;
            $appointment->price = $request->price; // Usamos el campo price
            $appointment->status = 'Completada';
            
            // Foto de salida
            if ($request->hasFile('checkout_photo')) {
                $file = $request->file('checkout_photo');
                $filename = 'checkout_' . time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                            . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('appointments/checkout', $filename, 'public');
                $appointment->checkout_photo = $path;
            }
            
            $appointment->save();
            
            // Sincronizar tratamientos aplicados
            $appointment->treatments()->sync($request->treatment_id);
            
            DB::commit();
            
            // Calcular duración
            $duration = $appointment->checkin_time->diffInMinutes($appointment->checkout_time);
            $hours = floor($duration / 60);
            $minutes = $duration % 60;
            $durationText = $hours > 0 ? "{$hours}h {$minutes}min" : "{$minutes}min";
            
            return response()->json([
                'success' => true,
                'message' => 'Servicio completado exitosamente',
                'checkout_time' => $appointment->checkout_time->format('d/m/Y g:i A'),
                'duration' => $durationText,
                'price' => $appointment->price,
                'status' => $appointment->status,
                'pet' => $appointment->pet_id ? $appointment->pet->name : $appointment->pet_name_temp,
                'gender' => $appointment->pet->gender ?? $appointment->gender_temp ?? 'Mascota Temporal',
                'phone' => $appointment->pet->client->emergency_phone ?? $appointment->phone_temp ?? '',
            ]);
            
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
    
    public function getAppointmentDetails($id)
    {
        $appointment = Appointment::with(['pet', 'pet.client', 'treatments'])
            ->findOrFail($id);

        $name = $appointment->pet->name;

        if (auth()->check() && $appointment->pet->sobriquet) {
            $name .= ' - ' . $appointment->pet->sobriquet;
        }
        
        return response()->json([
            'id' => $appointment->id,
            'pet_name' => $name,
            'client_name' => $appointment->pet->client->name,
            'client_phone' => $appointment->pet->client->emergency_phone,
            'appointment_date' => $appointment->appointment_date->format('d/m/Y g:i A'),
            'status' => $appointment->status,
            'price' => $appointment->price,
            'checkin' => [
                'time' => $appointment->checkin_time ? Carbon::parse($appointment->checkin_time)->format('d/m/Y g:i A') : null,
                'photo' => $appointment->checkin_photo ? asset('storage/' . $appointment->checkin_photo) : null,
                'observations' => $appointment->checkin_observations
            ],
            'process' => [
                'photo' => $appointment->process_photo ? asset('storage/' . $appointment->process_photo) : null,
                'observations' => $appointment->process_observations
            ],
            'checkout' => [
                'time' => $appointment->checkout_time ? Carbon::parse($appointment->checkout_time)->format('d/m/Y g:i A') : null,
                'photo' => $appointment->checkout_photo ? asset('storage/' . $appointment->checkout_photo) : null,
                'observations' => $appointment->checkout_observations
            ],
            'treatments' => $appointment->treatments->map(function($t) {
                return ['id' => $t->id, 'name' => $t->name];
            })
        ]);
    }
}