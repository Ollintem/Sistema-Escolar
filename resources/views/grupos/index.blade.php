@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-1">Gestión de Grupos y Asignaciones</h2>
            <p class="text-muted mb-0">Administración de grupos, turnos, docentes titulares y asignaturas.</p>
        </div>
        <div class="d-flex gap-2">
            @can('grupos.crear')
            <button class="btn btn-outline-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalNuevoGrado">
                <i class="bi bi-journal-plus me-1"></i> + Nuevo Grado
            </button>
            <button class="btn btn-primary rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#modalNuevoGrupo">
                <i class="bi bi-plus-lg me-1"></i> + Nuevo Grupo
            </button>
            @endcan
        </div>
    </div>

    <!-- Mensajes de Alerta -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Error al procesar la solicitud:</h6>
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabla de Grupos -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>GRUPO / TURNO</th>
                            <th>CICLO ESCOLAR</th>
                            <th>DOCENTE TITULAR</th>
                            <th>MATERIAS ASIGNADAS</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grupos as $grupo)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#{{ $grupo->id_grupo }}</td>
                            <td class="fw-bold text-dark">
                                {{ $grupo->grado->nombre ?? $grupo->grado }} - {{ $grupo->nombrgrupo ?? $grupo->grupo }} 
                                <span class="badge bg-secondary bg-opacity-10 text-secondary ms-1 fw-normal">
                                    {{ $grupo->turno }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $grupo->ciclo->nombre ?? 'Sin Asignar' }}
                                </span>
                            </td>
                            <td>{{ $grupo->docenteTitular->name ?? $grupo->docenteTitular->nombre ?? 'Sin Asignar' }}</td>
                            <td>
                                @forelse($grupo->materias as $materia)
                                    <span class="badge bg-info text-dark bg-opacity-10 me-1 mb-1">{{ $materia->nombre }}</span>
                                @empty
                                    <span class="text-muted small">Sin materias</span>
                                @endforelse
                            </td>
                            <td class="text-end pe-4">
                                @can('grupos.editar')
                                <button class="btn btn-sm btn-outline-primary rounded-circle me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-diagram-3 fs-1 d-block mb-2"></i>
                                No hay grupos registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Grado -->
<div class="modal fade" id="modalNuevoGrado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold">Registrar Nuevo Grado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('grados.store') }}" method="POST">
                @csrf
                <div class="modal-body py-0">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Grado *</label>
                        <input type="text" name="nombre" class="form-control rounded-3" placeholder="Ej. 1°, Primer Semestre" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 mt-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Guardar Grado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nuevo Grupo -->
<div class="modal fade" id="modalNuevoGrupo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold">Crear Nuevo Grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('grupos.store') }}" method="POST">
                @csrf
                <div class="modal-body py-0">
                    <div class="row g-3">
                        <!-- Selección Dinámica de Grados -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Grado *</label>
                            <select name="id_grado" class="form-select rounded-3" required>
                                <option value="">Seleccione Grado...</option>
                                @foreach($grados as $grado)
                                    <option value="{{ $grado->id_grado }}">{{ $grado->nombre }} ({{ $grado->nivel }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Grupo / Identificador *</label>
                            <input type="text" name="nombre" class="form-control rounded-3" placeholder="Ej. A, B, 101" required value="{{ old('nombre') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Turno *</label>
                            <select name="turno" class="form-select rounded-3" required>
                                <option value="Matutino">Matutino</option>
                                <option value="Vespertino">Vespertino</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Ciclo Escolar *</label>
                            <select name="id_ciclo" class="form-select rounded-3" required>
                                <option value="">Seleccione ciclo...</option>
                                @foreach($ciclos as $ciclo)
                                    <option value="{{ $ciclo->id_ciclo }}">{{ $ciclo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Docente Titular</label>
                            <select name="docente_id" class="form-select rounded-3">
                                <option value="">Sin Asignar</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}">{{ $docente->name ?? $docente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Asignar Materias</label>
                            <div class="row g-2 border rounded p-2 bg-light">
                                @forelse($materias as $materia)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="materias[]" value="{{ $materia->id_materia }}" id="mat_{{ $materia->id_materia }}">
                                            <label class="form-check-label small" for="mat_{{ $materia->id_materia }}">
                                                {{ $materia->nombre }}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-muted small ps-2">No hay materias registradas.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 mt-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Guardar Grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection