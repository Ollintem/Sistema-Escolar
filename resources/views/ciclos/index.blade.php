@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center pt-2 pb-2 mb-4 border-bottom">
    <h1 class="h3 fw-bold text-gray-800">Gestión de Ciclos Escolares</h1>
    <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalNuevoCiclo">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Ciclo
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
                        <th>Nombre del Ciclo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ciclos as $ciclo)
                    <tr>
                        <td class="fw-bold">#{{ $ciclo->id_ciclo }}</td>
                        <td>{{ $ciclo->nombre }}</td>
                        <td>{{ $ciclo->fecha_inicio }}</td>
                        <td>{{ $ciclo->fecha_fin }}</td>
                        <td>
                            @if($ciclo->estado === 'Activo')
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Cerrado</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('ciclos.toggle', $ciclo->id_ciclo) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $ciclo->estado === 'Activo' ? 'btn-outline-danger' : 'btn-outline-success' }} rounded-2">
                                    {{ $ciclo->estado === 'Activo' ? 'Cerrar Ciclo' : 'Aperturar Ciclo' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No hay ciclos escolares registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para Crear Ciclo -->
<div class="modal fade" id="modalNuevoCiclo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <form action="{{ route('ciclos.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Aperturar Ciclo Escolar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Ciclo</label>
                        <input type="text" name="nombre" class="form-control rounded-3" placeholder="Ej: 2026 - 2027" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Término</label>
                        <input type="date" name="fecha_fin" class="form-control rounded-3" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-3">Guardar Ciclo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection