<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';
    protected $primaryKey = 'id_alumno';

    protected $fillable = [
        'nombre',
        'apellido_p',
        'apellido_m',
        'fecha_nacimiento',
        'curp',
        'correo',
        'telefono',
        'foto',
        'tipo_sangre',
        'alergias',
        'observaciones_medicas',
        'tutor_nombre',
        'tutor_parentesco',
        'tutor_telefono',
        'tutor_email',
        'id_grupo', // <-- FK hacia la tabla groups
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id_grupo');
    }
}