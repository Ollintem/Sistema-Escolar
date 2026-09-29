<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_docente';

    protected $fillable = [
        'nombre',
        'apellido_p',
        'apellido_m',
        'correo',
        'telefono',
        'especialidad',
    ];
}