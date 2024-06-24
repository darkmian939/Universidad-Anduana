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
        'career_id',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relación con la carrera del estudiante
    public function careers()
    {
        return $this->belongsTo(Careers::class, 'career_id');
    }
}
