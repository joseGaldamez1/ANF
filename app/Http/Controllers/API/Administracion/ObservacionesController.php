<?php

namespace App\Http\Controllers\API\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Observaciones;
use Illuminate\Http\Request;

class ObservacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $observaciones = Observaciones::all();

        return response()->json([
            'message' => 'Lista de observaciones',
            'data' => $observaciones
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
