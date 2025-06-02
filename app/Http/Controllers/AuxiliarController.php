<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponseHelper; // 👈 Importa el helper

class AuxiliarController extends Controller
{
    public function añadir()
    {
        try {
            $usuario = User::create([
                'apellido_paterno' => 'Paz',
                'apellido_materno' => 'Bodero',
                'nombres_completos' => 'Minerva Antonella',
                'correo' => 't1022700821@unitru.edu.pe',
                'ciclo' => 9,
                'codigo' => '1022700821',
                'password' => Hash::make('1022700821'),
            ]);

            return ApiResponseHelper::success($usuario, "Usuario registrado correctamente");
        } catch (\Exception $e) {
            return ApiResponseHelper::error("No se pudo registrar el usuario", 500, $e->getMessage());
        }
    }
}
