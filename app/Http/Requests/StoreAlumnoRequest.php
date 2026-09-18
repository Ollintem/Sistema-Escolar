<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'apellido_p' => 'required|string|max:100',
            'apellido_m' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'curp' => 'required|string|size:18|unique:alumnos,curp',
            'correo' => 'required|email|unique:alumnos,correo',
            'telefono' => 'required|string|max:15',
            'id_grupo' => 'nullable|exists:grupos,id_grupo',
        ];
    }
}
