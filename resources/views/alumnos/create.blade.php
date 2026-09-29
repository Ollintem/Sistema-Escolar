@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Header Principal -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('alumnos.index') }}" class="btn btn-sm btn-light border rounded-circle">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill fw-bold">
                    <i class="bi bi-person-plus-fill me-1"></i> Expediente del Estudiante
                </span>
            </div>
            <h2 class="fw-bold text-dark mb-1">Registrar Nuevo Alumno</h2>
            <p class="text-muted mb-0">Completa los datos personales, médicos, del tutor y asignación de grupo.</p>
        </div>
    </div>

    <!-- Errores de Validación -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                <div>
                    <strong class="d-block">Por favor corrige los siguientes errores:</strong>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('alumnos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 1. Datos Personales -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <h6 class="fw-bold mb-0 text-primary d-flex align-items-center gap-2">
                    <i class="bi bi-person-vcard fs-5"></i> 1. Datos Personales del Alumno
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">NOMBRE(S) *</label>
                        <input type="text" name="nombre" class="form-control rounded-3" placeholder="Ej. Juan Carlos" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">APELLIDO PATERNO *</label>
                        <input type="text" name="apellido_p" class="form-control rounded-3" placeholder="Ej. Pérez" value="{{ old('apellido_p') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">APELLIDO MATERNO</label>
                        <input type="text" name="apellido_m" class="form-control rounded-3" placeholder="Ej. López" value="{{ old('apellido_m') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">FECHA DE NACIMIENTO</label>
                        <input type="date" name="fecha_nacimiento" class="form-control rounded-3" value="{{ old('fecha_nacimiento') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">CURP</label>
                        <input type="text" name="curp" class="form-control rounded-3 text-uppercase" placeholder="18 caracteres" maxlength="18" value="{{ old('curp') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">CORREO ELECTRÓNICO</label>
                        <input type="email" name="correo" class="form-control rounded-3" placeholder="alumno@escuela.com" value="{{ old('correo') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">TELÉFONO DE CONTACTO</label>
                        <input type="text" name="telefono" class="form-control rounded-3" placeholder="Ej. 5512345678" value="{{ old('telefono') }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-secondary small">FOTOGRAFÍA DEL ALUMNO (OPCIONAL)</label>
                        <input type="file" name="foto" class="form-control rounded-3" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Datos Médicos -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <h6 class="fw-bold mb-0 text-danger d-flex align-items-center gap-2">
                    <i class="bi bi-heart-pulse fs-5"></i> 2. Datos Médicos
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">TIPO DE SANGRE</label>
                        <select name="tipo_sangre" class="form-select rounded-3">
                            <option value="">Seleccione...</option>
                            <option value="O+" {{ old('tipo_sangre') == 'O+' ? 'selected' : '' }}>O Positivo (O+)</option>
                            <option value="O-" {{ old('tipo_sangre') == 'O-' ? 'selected' : '' }}>O Negativo (O-)</option>
                            <option value="A+" {{ old('tipo_sangre') == 'A+' ? 'selected' : '' }}>A Positivo (A+)</option>
                            <option value="A-" {{ old('tipo_sangre') == 'A-' ? 'selected' : '' }}>A Negativo (A-)</option>
                            <option value="B+" {{ old('tipo_sangre') == 'B+' ? 'selected' : '' }}>B Positivo (B+)</option>
                            <option value="B-" {{ old('tipo_sangre') == 'B-' ? 'selected' : '' }}>B Negativo (B-)</option>
                            <option value="AB+" {{ old('tipo_sangre') == 'AB+' ? 'selected' : '' }}>AB Positivo (AB+)</option>
                            <option value="AB-" {{ old('tipo_sangre') == 'AB-' ? 'selected' : '' }}>AB Negativo (AB-)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">ALERGIAS</label>
                        <input type="text" name="alergias" class="form-control rounded-3" placeholder="Ej. Ninguna, Penicilina, Polvo" value="{{ old('alergias') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">OBSERVACIONES MÉDICAS / TRATAMIENTO</label>
                        <input type="text" name="observaciones_medicas" class="form-control rounded-3" placeholder="Ej. Usa lentes, asmático" value="{{ old('observaciones_medicas') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Datos del Tutor Responsable -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <h6 class="fw-bold mb-0 text-warning d-flex align-items-center gap-2">
                    <i class="bi bi-people-fill fs-5"></i> 3. Datos del Tutor Responsable
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">NOMBRE DEL TUTOR *</label>
                        <input type="text" name="tutor_nombre" class="form-control rounded-3" placeholder="Ej. María Elena López" value="{{ old('tutor_nombre') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">PARENTESCO *</label>
                        <select name="tutor_parentesco" class="form-select rounded-3" required>
                            <option value="Madre" {{ old('tutor_parentesco') == 'Madre' ? 'selected' : '' }}>Madre</option>
                            <option value="Padre" {{ old('tutor_parentesco') == 'Padre' ? 'selected' : '' }}>Padre</option>
                            <option value="Tutor Legal" {{ old('tutor_parentesco') == 'Tutor Legal' ? 'selected' : '' }}>Tutor Legal</option>
                            <option value="Abuelo/a" {{ old('tutor_parentesco') == 'Abuelo/a' ? 'selected' : '' }}>Abuelo/a</option>
                            <option value="Otro" {{ old('tutor_parentesco') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">TELÉFONO *</label>
                        <input type="text" name="tutor_telefono" class="form-control rounded-3" placeholder="Ej. 5514789520" value="{{ old('tutor_telefono') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">EMAIL DE CONTACTO</label>
                        <input type="email" name="tutor_email" class="form-control rounded-3" placeholder="tutor@gmail.com" value="{{ old('tutor_email') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Adscripción Académica -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <h6 class="fw-bold mb-0 text-success d-flex align-items-center gap-2">
                    <i class="bi bi-building-check fs-5"></i> 4. Adscripción Académica
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-secondary small">GRUPO Y CICLO ESCOLAR *</label>
                        <select name="id_grupo" class="form-select form-select-lg rounded-3 fs-6" required>
                            <option value="">Seleccione el grupo correspondiente...</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id_grupo }}" {{ old('id_grupo') == $grupo->id_grupo ? 'selected' : '' }}>
                                    Grado: {{ $grupo->grado->nombre ?? $grupo->grado }} | Grupo: {{ $grupo->grupo ?? $grupo->nombre }} | Turno: {{ $grupo->turno }} (Ciclo: {{ $grupo->ciclo->nombre ?? 'Sin ciclo' }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-1 d-block">Selecciona el grupo donde será inscrito el alumno.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="d-flex justify-content-end gap-2 pb-5">
            <a href="{{ route('alumnos.index') }}" class="btn btn-light rounded-pill px-4 fw-semibold border">Cancelar</a>
            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                <i class="bi bi-check-circle me-1"></i> Registrar Alumno
            </button>
        </div>
    </form>
</div>
@endsection