<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Treatment;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = Treatment::all();
        return view('treatment.index', compact('treatments'));
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre es obligatorio',
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $treatment = new Treatment();
            $treatment->name = $validatedData['name'];
            $treatment->description = $request->input('description');
            $treatment->save();

            DB::commit();

            return redirect()->route('treatment.index')->with('success', 'Tratamiento creado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al crear el tratamiento');
        }
    }

    public function update(Request $request){
        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre es obligatorio',
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $treatment = Treatment::findOrFail($request->input('id'));
            $treatment->name = $validatedData['name'];
            $treatment->description = $request->input('description');
            $treatment->save();

            DB::commit();

            return redirect()->route('treatment.index')->with('success', 'Tratamiento actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al actualizar el tratamiento');
        }
    }

    public function delete($id){
        try {
            DB::beginTransaction();

            $treatment = Treatment::findOrFail($id);
            $treatment->delete();

            DB::commit();

            return redirect()->route('treatment.index')->with('success', 'Tratamiento eliminado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error al eliminar el tratamiento');
        }
    }
}
