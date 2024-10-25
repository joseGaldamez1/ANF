<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleados::with( 'institucion', 'puestoTrabajo', 'tipoDocumento')->get();

        return response()->json([
            'message' => 'Lista de empleados',
            'data' => $empleados
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre1' => 'required',
            'apellido1' => 'required',
            'tipo_documento_id' => 'required',
            'numero_documento' => 'required',
            'numero_afiliado' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'correo' => 'required',
            'fecha_ingreso' => 'required',
            'institucion_id' => 'required',
            'puesto_trabajo_id' => 'required',
        ]); 

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación',
                'errors' => $validator->errors()
            ]);
        }

        $empleado = Empleados::create([
            'nombre1' => $request->nombre1,
            'nombre2' => $request->nombre2,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'apellido_casada' => $request->apellido_casada,
            'tipo_documento_id' => $request->tipo_documento_id,
            'numero_documento' => $request->numero_documento,
            'numero_afiliado' => $request->numero_afiliado,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'institucion_id' => $request->institucion_id,
            'puesto_trabajo_id' => $request->puesto_trabajo_id,
        ]);

        return response()->json([
            'message' => 'Empleado creado exitosamente',
            'data' => $empleado
        ]);

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
        $empleado = Empleados::with( 'institucion', 'puestoTrabajo', 'tipoDocumento')->where('id', $id)->get();

        return response()->json([
            'message' => 'Empleado',
            'data' => $empleado
        ]);
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
        $empleado = Empleados::find($id);

        if (!$empleado) {
            return response()->json([
                'message' => 'Empleado no encontrado'
            ]);
        }

        $empleado->update($request->all());

        return response()->json([
            'message' => 'Empleado actualizado',
            'data' => $empleado
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $empleado = Empleados::find($id);

        if (!$empleado) {
            return response()->json([
                'message' => 'Empleado no encontrado'
            ]);
        }

        $empleado->delete();

        return response()->json([
            'message' => 'Empleado eliminado'
        ]);
    }
}
