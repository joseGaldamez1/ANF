<?php

namespace App\Http\Controllers;

use App\Models\PuestosTrabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PuestosTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $puestos = PuestosTrabajo::all();

        return response()->json([
            'message' => 'Lista de puestos de trabajo',
            'data' => $puestos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $puesto = PuestosTrabajo::create([
            'nombre' => $request->nombre,
        ]);

        return response()->json([
            'message' => 'Puesto de trabajo creado',
            'data' => $puesto
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $puesto = PuestosTrabajo::find($id);

        if (!$puesto) {
            return response()->json([
                'message' => 'Puesto de trabajo no encontrado'
            ], 404);
        }


        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $registro = $puesto->update([
            'nombre' => $request->nombre,
        ]);

        return response()->json([
            'message' => 'Puesto de trabajo actualizado',
            'data' => $registro
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
