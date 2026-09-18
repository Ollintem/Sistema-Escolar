<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_alumno';

    protected $fillable = [
        'nombre',
        'apellido_p',
        'apellido_m',
        'fecha_nacimiento',
        'curp',
        'correo',
        'telefono',
        'id_grupo',
    ];
}
