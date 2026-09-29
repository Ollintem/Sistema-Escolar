<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;

    protected $table = 'grados';
    protected $primaryKey = 'id_grado';

    protected $fillable = [
        'nombre',
    ];

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_grado', 'id_grado');
    }
}