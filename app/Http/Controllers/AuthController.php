<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponseHelper;
use Tymon\JWTAuth\Facades\JWTAuth;



class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar que username y password se reciban
        if (!$request->has('username') || !$request->has('password')) {
            return ApiResponseHelper::error('Faltan campos obligatorios: username y password', 422);
        }

        $username = $request->input('username');
        $password = $request->input('password');

        if (empty($username) || empty($password)) {
            return ApiResponseHelper::error('Username y password no pueden estar vacíos', 422);
        }


        // 2. Buscar usuario por código (username)
        $user = User::where('codigo', $request->username)->first();

        // 3. Verificar existencia del usuario y contraseña
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponseHelper::error("Credenciales inválidas", 401);
        }

        // Generar token JWT para el usuario autenticado
        $token = JWTAuth::fromUser($user);

        return ApiResponseHelper::success([
            'token' => $token,
            'user' => $user->only([
                'apellido_paterno',
                'apellido_materno',
                'nombres_completos',
                'correo',
                'ciclo',
                'codigo'
            ])
        ], "Inicio de sesión exitoso");
    }

    public function getUser()
    {
        // Si vas a usar JWT, aquí podrías devolver el usuario autenticado
        return ApiResponseHelper::success(auth()->user(), "Usuario autenticado");
    }

}
