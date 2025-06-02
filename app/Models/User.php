<?php

namespace App\Models;

// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use MongoDB\Laravel\Eloquent\HybridRelations;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HybridRelations;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'nombres_completos',
        'correo',
        'ciclo',
        'codigo',
        'password',
        'email',
        'role',
        'carrera',
        'bio',
        'librosSugeridos',
        'resenasUtiles',
        'librosGuardados',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Métodos requeridos por JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Normalmente el _id
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
