<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';
    protected $primaryKey = 'id_grupo';

    protected $fillable = [
        'grado',
        'grupo',
        'id_ciclo',
        'id_docente', // Docente Titular
    ];

    public function ciclo()
    {
        return $this->belongsTo(CicloEscolar::class, 'id_ciclo', 'id_ciclo');
    }

    public function docenteTitular()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'grupo_materia', 'id_grupo', 'id_materia');
    }
}