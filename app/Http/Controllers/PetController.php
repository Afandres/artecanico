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


        return view('pets.index', ['pets' => $pets]);
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
        do{
            $code = random_int(100000,999999);
        }while(Client::where('access_code',$code)->exists());

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
            dd($e);
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear la mascota'
            ], 500);
        }
    }
}
