@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Encabezado de la página -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">Registrar Nuevo Docente</h2>
        <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver a la Lista
        </a>
    </div>

    <!-- Tarjeta Principal del Formulario -->
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        <form action="{{ route('docentes.store') }}" method="POST">
            @csrf

            <!-- Seccion 1: Datos Personales -->
            <div class="mb-4">
                <h5 class="fw-bold text-primary mb-3">
                    <i class="bi bi-person me-2"></i>1. Datos Personales
                </h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nombre(s) <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Roberto" value="{{ old('nombre') }}" required>
                        @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Apellido Paterno <span class="text-danger">*</span></label>
                        <input type="text" name="apellido_p" class="form-control" placeholder="Ej. Gómez" value="{{ old('apellido_p') }}" required>
                        @error('apellido_p') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Apellido Materno <span class="text-danger">*</span></label>
                        <input type="text" name="apellido_m" class="form-control" placeholder="Ej. Hernández" value="{{ old('apellido_m') }}" required>
                        @error('apellido_m') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4 text-muted opacity-25">

            <!-- Seccion 2: Datos de Contacto -->
            <div class="mb-4">
                <h5 class="fw-bold text-primary mb-3">
                    <i class="bi bi-telephone me-2"></i>2. Datos de Contacto
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" name="correo" class="form-control" placeholder="docente@escuela.edu.mx" value="{{ old('correo') }}" required>
                        @error('correo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Teléfono <span class="text-danger">*</span></label>
                        <input type="text" name="telefono" class="form-control" placeholder="Ej. 55 1234 5678" value="{{ old('telefono') }}" required>
                        @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4 text-muted opacity-25">

            <!-- Seccion 3: Perfil y Especialidad -->
            <div class="mb-4">
                <h5 class="fw-bold text-primary mb-3">
                    <i class="bi bi-journal-bookmark me-2"></i>3. Perfil Académico
                </h5>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Especialidad / Perfil Profesional <span class="text-danger">*</span></label>
                        <input type="text" name="especialidad" class="form-control" placeholder="Ej. Lic. en Matemáticas, Pedagogía, Ciencias Naturales..." value="{{ old('especialidad') }}" required>
                        @error('especialidad') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('docentes.index') }}" class="btn btn-light px-4">Cancelar</a>
                <button type="submit" class="btn btn-primary px-4">Registrar Docente</button>
            </div>
        </form>
    </div>
</div>
@endsection