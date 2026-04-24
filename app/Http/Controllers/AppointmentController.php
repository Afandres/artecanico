<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Pet;
use App\Models\Appointment;
use App\Models\Treatment;
use App\Models\Client;

class AppointmentController extends Controller
{
    public function index()
    {
        $treatments = Treatment::get();
        return view('appointment.index', [
            'treatments' => $treatments,
        ]);
    }

    public function client($code = null)
    {
        $treatments = Treatment::get();
        return view('appointment.index', [
            'treatments' => $treatments,
            'code' => $code
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $cleanSearch = preg_replace('/[^a-z0-9\s]/', ' ', $search);

        // 🔥 quitar espacios duplicados
        $cleanSearch = preg_replace('/\s+/', ' ', $cleanSearch);

        // 🔥 convertir a array de palabras
        $terms = explode(' ', trim($cleanSearch));

        $pets = Pet::where(function ($query) use ($terms) {

            foreach ($terms as $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%$term%")
                        ->orWhere('sobriquet', 'like', "%$term%");
                });
            }
        })
            ->get();

        $existsExact = Pet::whereRaw('LOWER(name) = ?', [strtolower($search)])->exists();

        return response()->json([
            'results' => $pets->map(function ($pet) {
                return [
                    'id' => $pet->id,
                    'text' => $pet->name,
                    'sobriquet' => $pet->sobriquet,
                    'photo' => $pet->profile_photo
                        ? asset('storage/' . $pet->profile_photo)
                        : null,
                    'age' => $pet->age,
                    'gender' => $pet->gender,
                    'medical_condition' => $pet->medical_condition,
                    'observations' => $pet->observations,
                    'breed' => $pet->breed->name,
                    'client' => $pet->client->name,
                    'phone' => $pet->client->emergency_phone,
                ];
            }),
            'existsExact' => $existsExact
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'pet_id' => 'required',
            'time' => 'required',
        ];

        $messages = [
            'pet_id.required' => 'Debes seleccionar una mascota',
            'time.required' => 'Debes registrar una hora para la cita'
        ];

        $validatedData = $request->validate($rules, $messages);
        try {
            DB::beginTransaction();
            $datetime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $request->appointment_date . ' ' . $validatedData['time']
            );

            $exists = Appointment::where('pet_id', $validatedData['pet_id'])
                ->whereDate('appointment_date', $request->appointment_date)
                ->whereIn('status', ['Pendiente', 'En proceso'])
                ->exists();
            $pet = Pet::find($validatedData['pet_id']);

            if ($exists) {
                DB::rollBack();

                return back()->with('error', $pet->name . ' ya tiene una cita agendada para hoy.');
            }

            $appointment = new Appointment();
            $appointment->user_id = $request->input('user_id');
            $appointment->pet_id = $validatedData['pet_id'];
            $appointment->appointment_date = $datetime;
            $appointment->save();

            DB::commit();

            return redirect()->route('appointment.index')->with('success', 'Cita registrada',);
        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->with('error', 'Error al registrar la cita');
        }
    }

    public function events()
    {
        $appointments = Appointment::with(['pet', 'treatments'])->get();

        $events = [];

        foreach ($appointments as $appointment) {

            if (!$appointment->pet) continue;

            switch ($appointment->status) {
                case 'Pendiente':
                    $color = '#ffc107';
                    break;
                case 'En proceso':
                    $color = '#0d6efd';
                    break;
                case 'Completada':
                    $color = '#198754';
                    break;
                case 'Cancelada':
                    $color = '#dc3545';
                    break;
                default:
                    $color = '#6c757d';
            }

            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->pet->name . ' - ' . $appointment->pet->sobriquet,
                'start' => $appointment->appointment_date,
                'color' => $color,
                'extendedProps' => [
                    'pet_id' => $appointment->pet_id,
                    'client' => $appointment->pet->client->name ?? '',
                    'phone' => $appointment->pet->client->emergency_phone ?? '',
                    'breed' => $appointment->pet->breed->name ?? '',
                    'photo' => $appointment->pet->profile_photo ? asset('storage/' . $appointment->pet->profile_photo) : null,
                    'age' => $appointment->pet->age,
                    'gender' => $appointment->pet->gender,
                    'medical_condition' => $appointment->pet->medical_condition,
                    'observations' => $appointment->pet->observations,
                    'status' => $appointment->status,
                    'price' => number_format($appointment->price, 0, ',', '.'),
                    'checkin_time' => $appointment->checkin_time ? $appointment->checkin_time->format('d/m/Y g:i A') : null,
                    'checkin_photo' => $appointment->checkin_photo ? asset('storage/' . $appointment->checkin_photo) : null,
                    'checkin_observations' => $appointment->checkin_observations,
                    'process_photo' => $appointment->process_photo ? asset('storage/' . $appointment->process_photo) : null,
                    'process_observations' => $appointment->process_observations,
                    'checkout_time' => $appointment->checkout_time ? $appointment->checkout_time->format('d/m/Y g:i A') : null,
                    'checkout_photo' => $appointment->checkout_photo ? asset('storage/' . $appointment->checkout_photo) : null,
                    'checkout_observations' => $appointment->checkout_observations,
                    'treatments' => $appointment->treatments->map(function ($t) {
                        return ['id' => $t->id, 'name' => $t->name];
                    })
                ]
            ];
        }

        return response()->json($events);
    }

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

            $appointment->status = 'En proceso';
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

    public function cancelAppointment(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id'
        ]);

        try {
            DB::beginTransaction();
            $appointment = Appointment::findOrFail($request->appointment_id);

            // Validar que no se pueda cancelar si ya está completada
            if ($appointment->status === 'Completada') {
                throw new \Exception('No se puede cancelar una cita que ya está completada');
            }

            $appointment->status = 'Cancelada';
            $appointment->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cita cancelada exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function fullDays()
    {
        $days = Appointment::selectRaw('DATE(appointment_date) as date, COUNT(*) as total')
            ->groupBy('date')
            ->having('total', '>=', 7)
            ->pluck('date');

        $events = [];

        foreach ($days as $day) {
            $events[] = [
                'title' => 'No disponible',
                'start' => $day,
                'display' => 'background',
                'color' => '#ff4d4d'
            ];
        }

        return response()->json($events);
    }

    public function state(Request $request)
    {
        $appointment_id = $request->appointment_id;
        $status = $request->status;

        try {
            DB::beginTransaction();
            $appointment = Appointment::findOrFail($appointment_id);

            $appointment->status = $status;
            $appointment->observations = $request->observations;
            $appointment->price = $request->price;

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

                $file = $request->file('photo');

                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '.' . $file->getClientOriginalExtension();

                $path = $file->storeAs('appointments', $filename, 'public');
                $appointment->photo = $path;
            }
            $appointment->save();
            $appointment->treatments()->sync($request->treatment_id);

            DB::commit();

            $dates = [
                'success' => 'Estado de la cita cambiado',
                'phone' => $appointment->pet->client->emergency_phone,
                'pet' => $appointment->pet->name,
                'sobriquet' => $appointment->pet->sobriquet,
                'status' => $appointment->status,
                'gender' => $appointment->pet->gender
            ];
            return redirect()->route('appointment.index')->with($dates);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al cambiar estado de la cita');
        }
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required',
            'client_code' => 'required'
        ]);

        $appointment = Appointment::where('id', $request->appointment_id)
            ->whereHas('pet.client', function ($q) use ($request) {
                $q->where('access_code', $request->client_code);
            })
            ->firstOrFail();

        if ($appointment->status != 'Pendiente') {
            return back()->with('error', 'Solo citas pendientes pueden cancelarse');
        }

        $appointment->status = 'Cancelada';
        $appointment->save();

        // ADMIN logueado
        if (auth()->check()) {
            return redirect()
                ->route('appointment.index')
                ->with('success', 'Cita cancelada exitosamente');
        }

        // CLIENTE no logueado
        $code = $request->client_code; // hidden input

        return redirect()
            ->route('appointment.client.index', ['code' => $code])
            ->with('success', 'Cita cancelada exitosamente');
    }

    public function eventsByCode($code)
    {
        $client = Client::where('access_code', $code)->first();

        if (!$client) {
            return response()->json([]);
        }

        $appointments = Appointment::with('pet')
            ->whereHas('pet', function ($q) use ($client) {
                $q->where('client_id', $client->id);
            })
            ->get();

        $events = [];

        foreach ($appointments as $appointment) {
            if (!$appointment->pet) continue;

            switch ($appointment->status) {
                case 'Pendiente':
                    $color = '#ffc107'; // amarillo
                    break;
                case 'En proceso':
                    $color = '#0d6efd'; // azul
                    break;
                case 'Completada':
                    $color = '#198754'; // verde
                    break;
                case 'Cancelada':
                    $color = '#dc3545'; // rojo
                    break;
                default:
                    $color = '#6c757d'; // gris
            }

            $events[] = [
                'id' => $appointment->id,
                'title' => $appointment->pet->name,
                'start' => $appointment->appointment_date,
                'color' => $color,
                'extendedProps' => [
                    'pet_id' => $appointment->pet_id,
                    'photo' => $appointment->pet->profile_photo ? asset('storage/' . $appointment->pet->profile_photo) : null,
                    'client' => $appointment->pet->client->name,
                    'phone' => $appointment->pet->client->emergency_phone,
                    'breed' => $appointment->pet->breed->name,
                    'age' => $appointment->pet->age,
                    'medical_condition' => $appointment->pet->medical_condition,
                    'observations' => $appointment->pet->observations,
                    'gender' => $appointment->pet->gender,
                    'status' => $appointment->status
                ]
            ];
        }

        return response()->json($events);
    }

    public function checkin(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'checkin_photo' => 'nullable|image|max:2048',
            'checkin_observations' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $appointment = Appointment::findOrFail($request->appointment_id);

            if ($appointment->status === 'Cancelada') {
                throw new \Exception('No se puede registrar entrada de una cita cancelada');
            }

            if ($appointment->checkin_time) {
                throw new \Exception('Esta cita ya tiene registrada la entrada');
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
                'message' => '✅ Entrada registrada exitosamente',
                'checkin_time' => $appointment->checkin_time->format('g:i A'),
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

    public function checkout(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'final_price' => 'required|numeric|min:0',
            'checkout_observations' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $appointment = Appointment::findOrFail($request->appointment_id);

            if (!$appointment->checkin_time) {
                throw new \Exception('No se puede registrar salida sin haber registrado la entrada');
            }

            if ($appointment->checkout_time) {
                throw new \Exception('Esta cita ya tiene registrada la salida');
            }

            $appointment->checkout_time = now();
            $appointment->checkout_observations = $request->checkout_observations;
            $appointment->final_price = $request->final_price;
            $appointment->status = 'Completada';

            $appointment->save();

            DB::commit();

            // Calcular duración
            $duration = $appointment->checkin_time->diffInMinutes($appointment->checkout_time);
            $hours = floor($duration / 60);
            $minutes = $duration % 60;
            $durationText = $hours > 0 ? "{$hours}h {$minutes}min" : "{$minutes}min";

            return response()->json([
                'success' => true,
                'message' => '✅ Salida registrada exitosamente',
                'checkout_time' => $appointment->checkout_time->format('g:i A'),
                'duration' => $durationText,
                'final_price' => $appointment->final_price,
                'status' => $appointment->status,
                'pet_name' => $appointment->pet->name,
                'client_phone' => $appointment->pet->client->emergency_phone
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
