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
        'grado', // <-- Indispensable para permitir la asignación masiva del campo NOT NULL
        'grupo',
        'turno',
        'id_ciclo',
        'docente_id',
    ];

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'id_grado', 'id_grado');
    }

    public function ciclo()
    {
        return $this->belongsTo(CicloEscolar::class, 'id_ciclo', 'id_ciclo');
    }

    public function docenteTitular()
    {
        return $this->belongsTo(User::class, 'docente_id', 'id');
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'group_subject', 'group_id', 'subject_id');
    }
}