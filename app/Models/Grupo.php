<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'groups';
    protected $primaryKey = 'id_grupo';

    protected $fillable = [
        'id_grado',
        'grado', // Indispensable para permitir la asignación masiva del campo NOT NULL
        'grupo',
        'turno',
        'id_ciclo',
        'docente_id', // Docente titular general del grupo
    ];

    // Relación con el Grado académico
    public function grado()
    {
        return $this->belongsTo(Grado::class, 'id_grado', 'id_grado');
    }

    // Relación con el Ciclo Escolar
    public function ciclo()
    {
        return $this->belongsTo(CicloEscolar::class, 'id_ciclo', 'id_ciclo');
    }

    // Docente Titular general del grupo
    public function docenteTitular()
    {
        return $this->belongsTo(User::class, 'docente_id', 'id');
    }

    // Materias asignadas al grupo con su docente específico por asignatura
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'group_subject', 'id_grupo', 'id_materia')
                    ->withPivot('docente_id')
                    ->withTimestamps();
    }
}