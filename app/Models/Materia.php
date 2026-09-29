<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    // Nombre de la tabla en la BD creada en la migración
    protected $table = 'subjects'; 
    protected $primaryKey = 'id_materia';

    protected $fillable = [
        'clave',
        'nombre',
    ];
}