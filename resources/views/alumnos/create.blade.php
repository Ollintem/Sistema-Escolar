@extends('layouts.app')

@section('content')
<!-- Breadcrumbs & Title -->
<div class="mb-4">
    <nav aria-label="breadcrumb">
        
    </nav>
    <h2 class="fw-bold text-dark mb-0">Ficha de Registro de Alumno</h2>
    <p class="text-muted small mb-0">Completa toda la información obligatoria para registrar al nuevo estudiante en el sistema.</p>
</div>

<form action="{{ route('alumnos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        
        <!-- 1. Datos Personales -->
        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person me-2 text-primary"></i>1. Datos Personales</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Nombre(s) *</label>
                        <input type="text" name="nombre" class="form-control rounded-3" placeholder="María Guadalupe" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">CURP *</label>
                        <input type="text" name="curp" class="form-control rounded-3 text-uppercase" placeholder="GOLM150604HDFNRS08" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Apellido Paterno *</label>
                        <input type="text" name="apellido_p" class="form-control rounded-3" placeholder="González" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Fecha de Nacimiento *</label>
                        <input type="date" name="fecha_nacimiento" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Apellido Materno *</label>
                        <input type="text" name="apellido_m" class="form-control rounded-3" placeholder="López" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Género *</label>
                        <select name="genero" class="form-select rounded-3" required>
                            <option value="">Seleccione...</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Masculino">Masculino</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Recuadro para Fotografía -->
            <div class="col-md-4">
                <label class="form-label small fw-semibold d-block text-center">Fotografía del Alumno</label>
                <div class="border border-2 border-dashed rounded-4 p-4 text-center bg-light h-75 d-flex flex-column justify-content-center align-items-center">
                    <i class="bi bi-camera fs-1 text-muted"></i>
                    <span class="small text-muted mt-2">Subir archivo JPG o PNG (Max 5MB)</span>
                    <input type="file" name="foto" class="form-control form-control-sm mt-3 w-75">
                </div>
            </div>
        </div>

        <hr class="text-muted opacity-25">

        <!-- 2. Datos Médicos -->
        <h6 class="fw-bold text-dark my-3"><i class="bi bi-heart me-2 text-danger"></i>2. Datos Médicos</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Tipo de Sangre *</label>
                <select name="tipo_sangre" class="form-select rounded-3">
                    <option value="O Positivo (O+)">O Positivo (O+)</option>
                    <option value="A Positivo (A+)">A Positivo (A+)</option>
                    <option value="B Positivo (B+)">B Positivo (B+)</option>
                    <option value="AB Positivo (AB+)">AB Positivo (AB+)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Alergias</label>
                <input type="text" name="alergias" class="form-control rounded-3" placeholder="Ninguna conocida">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Observaciones Médicas / Tratamiento</label>
                <input type="text" name="observaciones_medicas" class="form-control rounded-3" placeholder="Usa lentes graduados para lectura.">
            </div>
        </div>

        <hr class="text-muted opacity-25">

        <!-- 3. Datos del Tutor Responsable -->
        <h6 class="fw-bold text-dark my-3"><i class="bi bi-people me-2 text-warning"></i>3. Datos del Tutor Responsable</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Nombre del Tutor *</label>
                <input type="text" name="tutor_nombre" class="form-control rounded-3" placeholder="Patricia López Ortiz" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Parentesco *</label>
                <select name="tutor_parentesco" class="form-select rounded-3" required>
                    <option value="Madre">Madre</option>
                    <option value="Padre">Padre</option>
                    <option value="Tutor Legal">Tutor Legal</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Teléfono *</label>
                <input type="text" name="tutor_telefono" class="form-control rounded-3" placeholder="55 4321 0987" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Email de Contacto *</label>
                <input type="email" name="tutor_email" class="form-control rounded-3" placeholder="patricia.lopez@gmail.com" required>
            </div>
        </div>

        <hr class="text-muted opacity-25">

        <!-- 4. Adscripción Académica -->
        <h6 class="fw-bold text-dark my-3"><i class="bi bi-bank me-2 text-info"></i>4. Adscripción Académica</h6>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Ciclo Escolar *</label>
                <select name="id_ciclo" class="form-select rounded-3" required>
                    <option value="">Seleccione Ciclo...</option>
                    @foreach($ciclos ?? [] as $ciclo)
                        <option value="{{ $ciclo->id_ciclo }}">{{ $ciclo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Grado de Ingreso *</label>
                <select name="grado" class="form-select rounded-3" required>
                    <option value="1° de Primaria">1° de Primaria</option>
                    <option value="2° de Primaria">2° de Primaria</option>
                    <option value="3° de Primaria">3° de Primaria</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Grupo Asignado *</label>
                <select name="id_grupo" class="form-select rounded-3" required>
                    <option value="">Seleccione Grupo...</option>
                    @foreach($grupos ?? [] as $grupo)
                        <option value="{{ $grupo->id_grupo }}">{{ $grupo->nombre }} - {{ $grupo->turno }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

    <!-- Botones de Acción -->
    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="{{ route('alumnos.index') }}" class="btn btn-light rounded-3 px-4">Cancelar</a>
        <button type="submit" class="btn btn-primary rounded-3 px-4">Registrar Alumno</button>
    </div>
</form>
@endsection