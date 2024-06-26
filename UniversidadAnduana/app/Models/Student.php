<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'nombre_carrera', // Agregamos 'nombre_carrera' al array $fillable
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Aquí podrías añadir relaciones con otras tablas si es necesario

}
