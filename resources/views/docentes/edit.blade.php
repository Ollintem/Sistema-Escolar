@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">Editar Docente</h2>
        <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary">
            Volver a la Lista
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <form action="{{ route('docentes.update', $docente->id_docente) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- 1. Datos Personales -->
            <div class="mb-4">
                <h5 class="fw-bold text-primary mb-3">1. Datos Personales</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nombre(s) *</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $docente->nombre) }}" required>
                        @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Apellido Paterno *</label>
                        <input type="text" name="apellido_p" class="form-control" value="{{ old('apellido_p', $docente->apellido_p) }}" required>
                        @error('apellido_p') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Apellido Materno *</label>
                        <input type="text" name="apellido_m" class="form-control" value="{{ old('apellido_m', $docente->apellido_m) }}" required>
                        @error('apellido_m') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4 text-muted opacity-25">

            <!-- 2. Información de Contacto -->
            <div class="mb-4">
                <h5 class="fw-bold text-primary mb-3">2. Información de Contacto</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Correo Electrónico *</label>
                        <input type="email" name="correo" class="form-control" value="{{ old('correo', $docente->correo) }}" required>
                        @error('correo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Teléfono *</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $docente->telefono) }}" required>
                        @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4 text-muted opacity-25">

            <!-- 3. Perfil Académico -->
            <div class="mb-4">
                <h5 class="fw-bold text-primary mb-3">3. Perfil Académico</h5>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Especialidad / Perfil Profesional *</label>
                        <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad', $docente->especialidad) }}" required>
                        @error('especialidad') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('docentes.index') }}" class="btn btn-light px-4">Cancelar</a>
                <button type="submit" class="btn btn-primary px-4">Actualizar Docente</button>
            </div>
        </form>
    </div>
</div>
@endsection