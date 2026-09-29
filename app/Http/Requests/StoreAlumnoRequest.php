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
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'curp' => 'required|string|size:18|unique:students,curp',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
            'tipo_sangre' => 'required|string',
            'alergias' => 'nullable|string',
            'observaciones_medicas' => 'nullable|string',
            'tutor_nombre' => 'required|string|max:150',
            'tutor_parentesco' => 'required|string',
            'tutor_telefono' => 'required|string',
            'tutor_email' => 'required|email',
            'id_ciclo' => 'required|exists:ciclo_escolars,id_ciclo',
            'id_grupo' => 'required|exists:groups,id_grupo',
        ];
    }
}