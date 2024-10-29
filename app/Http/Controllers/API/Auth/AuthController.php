<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        // Validación de los campos de inicio de sesión
        $validator = Validator::make($request->all(), [
            'identity' => ['required'],
            'password' => ['required']
        ], [
            'identity.required' => 'Correo Electrónico o Nombre de Usuario debe ser ingresado',
            'password.required' => 'Contraseña debe ser ingresada'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Determinar si el campo de identidad es un email o un nombre de usuario
        $identity = filter_var($request->identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $identity => $request->identity,
            'password' => $request->password
        ];

        // Intentar autenticación
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json([
                'user' => $user,
                'access_token' => $accessToken,
                'message' => 'Inicio de sesión exitoso'
            ], 200);
        } else {
            return response()->json(['message' => 'Credenciales inválidas'], 400);
        }
    }

    public function signout(Request $request)
    {
        if ($user = $request->user('api')) {
            $accessToken = $user->token();
            $accessToken->revoke();

            return response()->json([
                'message' => 'Cierre de sesión correcto',
            ]);
        }

        return response()->json(['message' => 'Usuario no autenticado'], 401);
    }
    
}
