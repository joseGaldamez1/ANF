<?php

namespace App\Http\Controllers;

use App\Models\PuestosTrabajo;
use Illuminate\Http\Request;

class PuestoTrabajoController extends Controller
{

    public function index()
    {
        $puestos = PuestosTrabajo::all();
        return response()->json(['data' => $puestos]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $puesto = PuestosTrabajo::create([
            'nombre' => $request->nombre,
        ]);

        return response()->json(['message' => 'Puesto de trabajo creado exitosamente', 'data' => $puesto], 201);
    }

    public function show($id)
    {
        $puesto = PuestosTrabajo::find($id);

        if (!$puesto) {
            return response()->json(['message' => 'Puesto de trabajo no encontrado'], 404);
        }

        return response()->json(['data' => $puesto]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $puesto = PuestosTrabajo::find($id);

        if (!$puesto) {
            return response()->json(['message' => 'Puesto de trabajo no encontrado'], 404);
        }

        $puesto->update([
            'nombre' => $request->nombre,
        ]);

        return response()->json(['message' => 'Puesto de trabajo actualizado exitosamente', 'data' => $puesto]);
    }


    public function destroy($id)
    {
        $puesto = PuestosTrabajo::findOrFail($id);
 
        if ($puesto->empleados()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar el puesto de trabajo porque tiene empleados asociados.'
            ], 400);
        }
    
        $puesto->delete();
        return response()->json(['message' => 'Puesto de trabajo eliminado exitosamente']);
    }
    
}
