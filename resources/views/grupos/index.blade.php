@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center pt-2 pb-2 mb-4 border-bottom">
    <h1 class="h3 fw-bold text-gray-800">Gestión de Grupos y Asignaciones</h1>
    <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalNuevoGrupo">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Grupo
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Grupo / Turno</th>
                        <th>Ciclo Escolar</th>
                        <th>Docente Titular</th>
                        <th>Materias Asignadas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grupos as $grupo)
                    <tr>
                        <td class="fw-bold">#{{ $grupo->id_grupo }}</td>
                        <td>
                            <span class="badge bg-primary fs-6">{{ $grupo->nombre }}</span>
                            <small class="text-muted d-block">{{ $grupo->turno }}</small>
                        </td>
                        <td>{{ $grupo->ciclo->nombre ?? 'Sin Ciclo' }}</td>
                        <td>{{ $grupo->docenteTitular->nombre ?? 'Sin Titular' }}</td>
                        <td>
                            @forelse($grupo->materias as $materia)
                                <span class="badge bg-light text-dark border me-1">{{ $materia->nombre }}</span>
                            @empty
                                <span class="text-muted small">Sin materias</span>
                            @endforelse
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No hay grupos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Formulario -->
<div class="modal fade" id="modalNuevoGrupo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <form action="{{ route('grupos.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Nuevo Grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre del Grupo</label>
                            <input type="text" name="nombre" class="form-control rounded-3" placeholder="Ej: 1° A" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Turno</label>
                            <select name="turno" class="form-select rounded-3" required>
                                <option value="Matutino">Matutino</option>
                                <option value="Vespertino">Vespertino</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ciclo Escolar</label>
                            <select name="id_ciclo" class="form-select rounded-3" required>
                                <option value="">Seleccione ciclo...</option>
                                @foreach($ciclos as $ciclo)
                                    <option value="{{ $ciclo->id_ciclo }}">{{ $ciclo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Docente Titular</label>
                            <select name="id_docente" class="form-select rounded-3">
                                <option value="">Seleccione titular...</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id_docente }}">{{ $docente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Asignar Materias</label>
                            <div class="row">
                                @forelse($materias as $materia)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="materias[]" value="{{ $materia->id_materia }}" id="mat_{{ $materia->id_materia }}">
                                            <label class="form-check-label" for="mat_{{ $materia->id_materia }}">
                                                {{ $materia->nombre }}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted small ps-3">No hay materias en la base de datos.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-3">Guardar Grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection