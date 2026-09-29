@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-1">Módulo de Materias</h2>
            <p class="text-muted mb-0">Gestión de asignaturas y catálogo académico del sistema.</p>
        </div>
        @can('materias.crear')
        <button class="btn btn-primary rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#modalNuevaMateria">
            <i class="bi bi-plus-lg me-2"></i>Nueva Materia
        </button>
        @endcan
    </div>

    <!-- Lista de Materias -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">CLAVE</th>
                            <th>NOMBRE DE LA MATERIA</th>
                            <th>FECHA DE REGISTRO</th>
                            <th class="text-end pe-4">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materias ?? [] as $materia)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $materia->clave }}</td>
                            <td class="fw-bold text-dark">{{ $materia->nombre }}</td>
                            <td>{{ $materia->created_at ? $materia->created_at->format('d/m/Y') : 'N/A' }}</td>
                            <td class="text-end pe-4">
                                @can('materias.editar')
                                <button class="btn btn-sm btn-outline-primary rounded-circle me-1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                @endcan
                                @can('materias.eliminar')
                                <button class="btn btn-sm btn-outline-danger rounded-circle">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                No se encontraron materias registradas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Materia -->
<div class="modal fade" id="modalNuevaMateria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold">Agregar Nueva Materia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('materias.index') }}" method="POST">
                @csrf
                <div class="modal-body py-0">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Clave de la Materia *</label>
                        <input type="text" name="clave" class="form-control" placeholder="Ej. MAT-101" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre de la Materia *</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Matemáticas I" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Guardar Materia</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection