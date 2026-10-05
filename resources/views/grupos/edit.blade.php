@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill fw-bold mb-2">
                <i class="bi bi-pencil-square me-1"></i> Control Académico
            </span>
            <h2 class="fw-bold text-dark mb-1">Editar Grupo: {{ $grupo->grado }} - {{ $grupo->grupo }}</h2>
            <p class="text-muted mb-0">Actualiza la información del grupo, turno, ciclo y la asignación de materias con sus docentes impartidores.</p>
        </div>
        <a href="{{ route('grupos.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-1"></i> Volver a la Lista
        </a>
    </div>

    <!-- Formulario de Edición -->
    <form action="{{ route('grupos.update', $grupo->id_grupo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Datos Generales</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">GRADO *</label>
                        <select name="id_grado" class="form-select rounded-3" required>
                            @foreach($grados as $grado)
                                <option value="{{ $grado->id_grado }}" {{ $grupo->id_grado == $grado->id_grado ? 'selected' : '' }}>
                                    {{ $grado->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">GRUPO / NOMBRE *</label>
                        <input type="text" name="nombre" class="form-control rounded-3" value="{{ old('nombre', $grupo->grupo) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">TURNO *</label>
                        <select name="turno" class="form-select rounded-3" required>
                            <option value="Matutino" {{ $grupo->turno == 'Matutino' ? 'selected' : '' }}>Matutino</option>
                            <option value="Vespertino" {{ $grupo->turno == 'Vespertino' ? 'selected' : '' }}>Vespertino</option>
                            <option value="Nocturno" {{ $grupo->turno == 'Nocturno' ? 'selected' : '' }}>Nocturno</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">CICLO ESCOLAR *</label>
                        <select name="id_ciclo" class="form-select rounded-3" required>
                            @foreach($ciclos as $ciclo)
                                <option value="{{ $ciclo->id_ciclo }}" {{ $grupo->id_ciclo == $ciclo->id_ciclo ? 'selected' : '' }}>
                                    {{ $ciclo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">DOCENTE TITULAR</label>
                        <select name="docente_id" class="form-select rounded-3">
                            <option value="">Sin Docente Titular</option>
                            @foreach($docentes as $docente)
                                <option value="{{ $docente->id }}" {{ $grupo->docente_id == $docente->id ? 'selected' : '' }}>
                                    {{ $docente->name ?? $docente->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asignación de Materias y Docentes -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-journal-check text-primary me-2"></i>Materias y Docentes Impartidores</h5>
                
                @php
                    // Mapear materias asignadas con el ID del docente impartidor
                    $materiasAsignadas = $grupo->materias->keyBy('id_materia');
                @endphp

                <div class="list-group list-group-flush border rounded-3">
                    @foreach($materias as $materia)
                        @php
                            $mId = $materia->id_materia ?? $materia->id;
                            $estaAsignada = $materiasAsignadas->has($mId);
                            $docenteAsignadoId = $estaAsignada ? $materiasAsignadas[$mId]->pivot->docente_id : null;
                        @endphp
                        <div class="list-group-item p-3">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="materias[]" value="{{ $mId }}" id="mat_{{ $mId }}" {{ $estaAsignada ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold text-dark" for="mat_{{ $mId }}">
                                            {{ $materia->nombre }} <span class="text-muted font-monospace">({{ $materia->clave ?? 'S/C' }})</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <select name="docentes_materia[{{ $mId }}]" class="form-select form-select-sm rounded-3">
                                        <option value="">Seleccionar Docente Impartidor...</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}" {{ $docenteAsignadoId == $docente->id ? 'selected' : '' }}>
                                                {{ $docente->name ?? $docente->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer bg-white p-4 text-end border-top">
                <a href="{{ route('grupos.index') }}" class="btn btn-light rounded-pill px-4 me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>
@endsection