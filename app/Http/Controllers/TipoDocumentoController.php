<?php

namespace App\Http\Controllers;

use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class TipoDocumentoController extends Controller
{
 
    public function index()
    {
        $tiposDocumento = TipoDocumento::all();

        return response()->json([
            'message' => 'Lista de tipos de documento',
            'data' => $tiposDocumento
        ]);
    }


    public function store(Request $request)
    {

        $request->validate([
            'codigo' => 'required|string|max:10|unique:tipo_documento,codigo',
            'nombre' => 'required|string|max:255',
        ]);

        $tipoDocumento = TipoDocumento::create($request->all());

        return response()->json([
            'message' => 'Tipo de documento creado exitosamente',
            'data' => $tipoDocumento
        ], 201);
    }


    public function show($id)
    {
        $tipoDocumento = TipoDocumento::find($id);

        if (!$tipoDocumento) {
            return response()->json(['message' => 'Tipo de documento no encontrado'], 404);
        }

        return response()->json([
            'message' => 'Tipo de documento encontrado',
            'data' => $tipoDocumento
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'string|max:10|unique:tipo_documento,codigo,' . $id,
            'nombre' => 'string|max:255',
        ]);

        $tipoDocumento = TipoDocumento::find($id);

        if (!$tipoDocumento) {
            return response()->json(['message' => 'Tipo de documento no encontrado'], 404);
        }

        $tipoDocumento->update($request->all());

        return response()->json([
            'message' => 'Tipo de documento actualizado exitosamente',
            'data' => $tipoDocumento
        ]);
    }


    public function destroy($id)
    {
        $tipoDocumento = TipoDocumento::find($id);

        if (!$tipoDocumento) {
            return response()->json(['message' => 'Tipo de documento no encontrado'], 404);
        }

        $tipoDocumento->delete();

        return response()->json(['message' => 'Tipo de documento eliminado exitosamente']);
    }
}
