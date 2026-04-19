<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Breed;

class BreedController extends Controller
{
    public function index()
    {
        $breeds = Breed::all();
        return view('breed.index', compact('breeds'));
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'size' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'size.required' => 'El tamaño es requerido',
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $breed = new Breed();
            $breed->name = $validatedData['name'];
            $breed->size = $validatedData['size'];
            $breed->description = $request->input('description');
            $breed->save();

            DB::commit();

            return redirect()->route('breed.index')->with('success', 'Raza creada exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al crear la raza');
        }
    }

    public function update(Request $request){
        $rules = [
            'name' => 'required',
            'size' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'size.required' => 'El tamaño es requerido',
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $breed = Breed::findOrFail($request->input('id'));
            $breed->name = $validatedData['name'];
            $breed->size = $validatedData['size'];
            $breed->description = $request->input('description');
            $breed->save();

            DB::commit();

            return redirect()->route('breed.index')->with('success', 'Raza editada exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al editar la raza');
        }
    }

    public function delete($id){
        try {
            DB::beginTransaction();

            $breed = Breed::findOrFail($id);
            $breed->delete();

            DB::commit();

            return redirect()->route('breed.index')->with('success', 'Raza eliminada exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al eliminar la raza');
        }
    }
}
