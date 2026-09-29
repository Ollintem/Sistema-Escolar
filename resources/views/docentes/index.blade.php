@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Encabezado exclusivo de Docentes -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">Docentes</h2>
        <a href="{{ route('docentes.create') }}" class="btn btn-primary">
            + Nuevo Docente
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabla de Docentes -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Especialidad</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($docentes as $docente)
                            <tr>
                                <td class="fw-bold">{{ $docente->nombre }} {{ $docente->apellido_p }} {{ $docente->apellido_m }}</td>
                                <td>{{ $docente->correo }}</td>
                                <td>{{ $docente->telefono }}</td>
                                <td><span class="badge bg-info text-dark">{{ $docente->especialidad }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('docentes.edit', $docente->id_docente) }}" class="btn btn-sm btn-outline-primary me-1">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No hay docentes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection