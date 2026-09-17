@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center pt-2 pb-2 mb-4 border-bottom">
    <h1 class="h3 fw-bold text-gray-800">Control Escolar y Expedientes</h1>
    <button class="btn btn-primary rounded-3">
        <i class="bi bi-person-plus-fill me-1"></i> Inscribir Alumno
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
                        <th>Alumno</th>
                        <th>CURP</th>
                        <th>Contacto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumnos as $alumno)
                    <tr>
                        <td class="fw-bold">#{{ $alumno->id_alumno }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle fs-3 me-2 text-secondary"></i>
                                <div>
                                    <span class="fw-bold d-block">{{ $alumno->nombre }} {{ $alumno->apellido_p }} {{ $alumno->apellido_m }}</span>
                                    <small class="text-muted">{{ $alumno->fecha_nacimiento }}</small>
                                </div>
                            </div>
                        </td>
                        <td><code>{{ $alumno->curp }}</code></td>
                        <td>
                            <small class="d-block"><i class="bi bi-envelope me-1"></i>{{ $alumno->correo }}</small>
                            <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $alumno->telefono }}</small>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary rounded-2">
                                <i class="bi bi-file-earmark-arrow-up"></i> Documentos
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No hay alumnos registrados en la base de datos.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection