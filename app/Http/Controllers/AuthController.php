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
    try {
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
        $user = User::where('codigo', $username)->first();

        // 3. Verificar existencia del usuario y contraseña
        if (!$user || !Hash::check($password, $user->password)) {
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

    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        // Error específico de JWT
        \Log::error('JWT Error en login: ' . $e->getMessage(), [
            'username' => $request->input('username'),
            'trace' => $e->getTraceAsString()
        ]);
        return ApiResponseHelper::error('Error al generar token de autenticación', 500);

    } catch (\Illuminate\Database\QueryException $e) {
        // Error de base de datos
        \Log::error('Database Error en login: ' . $e->getMessage(), [
            'username' => $request->input('username'),
            'trace' => $e->getTraceAsString()
        ]);
        return ApiResponseHelper::error('Error de conexión a la base de datos', 500);

    } catch (\Exception $e) {
        // Cualquier otro error
        \Log::error('Error general en login: ' . $e->getMessage(), [
            'username' => $request->input('username'),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        return ApiResponseHelper::error('Error interno del servidor', 500);
    }
}

    public function getUser()
    {
        // Si vas a usar JWT, aquí podrías devolver el usuario autenticado
        return ApiResponseHelper::success(auth()->user(), "Usuario autenticado");
    }

}
