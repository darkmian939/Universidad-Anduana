<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Careers extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_carrera'];

    // Relación con estudiantes (si es necesaria)
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
