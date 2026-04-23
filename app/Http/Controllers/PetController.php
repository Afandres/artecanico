<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PetController extends Controller
{
    public function index(){
        $pets = Pet::with(['client', 'breed'])
        ->join('clients', 'clients.id', '=', 'pets.client_id')
        ->orderBy('clients.name', 'asc')   // agrupa por dueño
        ->orderBy('pets.name', 'asc')      // ordena mascotas dentro del dueño
        ->select('pets.*')
        ->get();

        $breeds = Breed::get();

        return view('pets.index', [
            'pets' => $pets,
            'breeds' => $breeds
        ]);
    }

    public function client($code = null)
    {
        $client_id = Client::where('access_code', $code)->pluck('id');
        $pets = Pet::with(['client', 'breed'])
        ->where('client_id', $client_id)
        ->get();

        $breeds = Breed::get();

        return view('pets.index', [
            'pets' => $pets,
            'breeds' => $breeds,
            'code' => $code
        ]);
    }

    public function getBreeds(Request $request)
    {
        $search = $request->search;

        $breeds = Breed::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })->get();

        return response()->json($breeds);
    }

    public function getClients (Request $request){

        $search = $request->search;

        $clients = Client::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })->get();

        return response()->json($clients);
    }

    private function generateCode()
    {
        do {
            $code = Str::upper(Str::random(10));
        } while (Client::where('access_code', $code)->exists());

        return $code;
    }

    public function store(Request $request){
        $clientId = $request->client_id;

        $newClient = false;
        $client = null;

        
        if (!is_numeric($clientId)) {
            // 🔍 buscar si ya existe (por seguridad)
            $client = Client::whereRaw('LOWER(name) = ?', [strtolower($clientId)])->first();
            if (!$client) {
                // 🆕 crear cliente nuevo
                $client = Client::create([
                    'name' => $request->client_id,
                    'emergency_phone' => $request->emergency_phone,
                    'access_code' => $this->generateCode()
                    ]);

                    $newClient = true;
            }
            $clientId = $client->id;
        }else{
            $client = Client::find($clientId);
        }
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'new_pet_name' => [
                'required',
                Rule::unique('pets', 'name')
                    ->where(function ($query) use ($clientId) {
                        return $query->where('client_id', $clientId);
                    })
            ],
            'breed_id' => 'required',
            'gender' => 'required',
        ], [
            'client_id.required' => 'El cliente/dueño es obligatorio',
            'new_pet_name.required' => 'El nombre de la mascota es obligatorio',
            'new_pet_name.unique' => 'Ya existe una mascota con ese nombre para este cliente',
            'breed_id.required' => 'La raza es obligatoria',
            'gender.required' => 'Debes seleccionar un género',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $data = $validator->validated();

            // 🔥 separar nombre y sobrenombre
            $fullName = $data['new_pet_name'];

            $parts = explode('-', $fullName, 2);

            $name = trim($parts[0]); // siempre existe
            $sobriquet = isset($parts[1]) ? trim($parts[1]) : null;

            $pet = new Pet();
            $pet->client_id = $clientId;
            $pet->breed_id = $data['breed_id'];
            $pet->name = $name;
            $pet->sobriquet = $sobriquet;
            $pet->age = $request->age;
            $pet->gender = $data['gender'];
            $pet->medical_condition = $request->medical_condition;
            $pet->observations = $request->observations;
            if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {

                $file = $request->file('profile_photo');

                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                            . '.' . $file->getClientOriginalExtension();

                $path = $file->storeAs('pets', $filename, 'public');

                $pet->profile_photo = $path;
            }

            $pet->save();

            DB::commit();

            return response()->json([
                'id' => $pet->id,
                'name' => $pet->name . " - " . $pet->sobriquet,
                'photo' => $pet->profile_photo ? asset('storage/' . $pet->profile_photo) : null,
                'client' => $client->name,
                'phone' => $client->emergency_phone,
                'breed' => $pet->breed->name,
                'age' => $pet->age,
                'gender' => $pet->gender,
                'medical_condition' => $pet->medical_condition,
                'observations' => $pet->observations,
                'access_code' => $client->access_code,
                'new_client' => $newClient,
                'message' => 'Mascota creada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear la mascota'
            ], 500);
        }
    }

    public function update(Request $request){
        $rules = [
            'name' => 'required',
            'breed_id' => 'required',
            'sobriquet' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre de la mascota es obligatorio',
            'breed_id.required' => 'La raza es obligatoria',
            'sobriquet.required' => 'El apodo de la mascota es requerido',
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $pet = Pet::findOrFail($request->input('id'));
            $pet->name = $validatedData['name'];
            $pet->sobriquet = $validatedData['sobriquet'];
            $pet->breed_id = $validatedData['breed_id'];
            $pet->age = $request->input('age');
            $pet->gender = $request->input('gender');
            $pet->medical_condition = $request->input('medical_condition');
            $pet->observations = $request->input('observations');
            if ($request->hasFile('profile_photo')) {

                if ($pet->profile_photo && Storage::disk('public')->exists($pet->profile_photo)) {
                    Storage::disk('public')->delete($pet->profile_photo);
                }

                $path = $request->file('profile_photo')->store('pets', 'public');

                $pet->profile_photo = $path;
            }

            $pet->save();

            DB::commit();

            return redirect()->route('pet.index')->with('success', 'Mascota editada exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al editar la mascota');
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $pet = Pet::findOrFail($id);
            $pet->delete();

            DB::commit();

            return redirect()->route('pet.index')->with('success', 'Mascota eliminada exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al eliminar la mascota');
        }
    }

    public function update_client(Request $request){
        $rules = [
            'name' => 'required',
            'emergency_phone' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre del cliente es obligatorio',
            'emergency_phone.required' => 'El numero de celular del cliente es requerido',
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $client = Client::findOrFail($request->input('id'));
            $client->name = $validatedData['name'];
            $client->emergency_phone = $validatedData['emergency_phone'];
            $client->save();

            DB::commit();

            return redirect()->route('pet.index')->with('success', 'Cliente editado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al editar al cliente');
        }
    }

    public function delete_client($id)
    {
        try {
            DB::beginTransaction();

            $client = Client::findOrFail($id);
            $client->delete();

            DB::commit();

            return redirect()->route('pet.index')->with('success', 'Cliente eliminado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al eliminar al cliente');
        }
    }
}
