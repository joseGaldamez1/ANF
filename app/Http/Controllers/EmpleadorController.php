<?php

namespace App\Http\Controllers;

use App\Models\Empleador;
use Illuminate\Http\Request;

class EmpleadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $empleador = Empleador::with('tipoDocumento')->get();

    return response()->json([
        'message' => 'Datos del Empleador',
        'data' => $empleador->map(function($emp) {
            return [
                'id' => $emp->id,
                'tipo_documento_id' => $emp->tipo_documento_id,
                'numero_documento' => $emp->numero_documento,
                'numero_patronal' => $emp->numero_patronal,
                'centro_trabajo' => $emp->centro_trabajo,
                'nombre_empresa' => 'ANALISIS FINANCIERO, S.A DE C.V.',
                'nit_empresa' => '0601-100101-101-1',
                'tipo_documento' => [
                    'id' => $emp->tipoDocumento->id,
                    'codigo' => $emp->tipoDocumento->codigo,
                    'nombre' => $emp->tipoDocumento->nombre,
                ],
            ];
        })
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
