@extends('layouts.app')

@section('content')
<!-- Breadcrumbs & Header -->
<div class="mb-3">
    <nav aria-label="breadcrumb">
        
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold text-dark mb-0">Alumnos</h2>
            
        </div>
        <a href="{{ route('alumnos.create') }}" class="btn btn-primary rounded-3 px-3 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> + Nuevo Alumno
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Card Principal con Filtros y Tabla -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        
        <!-- Filtros Rápidos -->
        <form method="GET" action="{{ route('alumnos.index') }}" class="row g-2 mb-4">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="buscar" class="form-control border-start-0 ps-0" placeholder="Buscar por nombre o matrícula..." value="{{ request('buscar') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="grado" class="form-select text-muted">
                    <option value="">Grado: Todos</option>
                    <option value="1">1°</option>
                    <option value="2">2°</option>
                    <option value="3">3°</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="grupo" class="form-select text-muted">
                    <option value="">Grupo: Todos</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="estado" class="form-select text-muted">
                    <option value="">Estado: Activos</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
        </form>

        <!-- Tabla de Alumnos -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th>Foto</th>
                        <th>Matrícula</th>
                        <th>Nombre Completo</th>
                        <th>Grado</th>
                        <th>Grupo</th>
                        <th>Tutor</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($alumnos as $alumno)
                    <tr>
                        <td>
                            <img src="{{ $alumno->foto ? asset('storage/'.$alumno->foto) : 'https://ui-avatars.com/api/?name='.urlencode($alumno->nombre.' '.$alumno->apellido_p)&'background=random' }}" 
                                 class="rounded-circle object-fit-cover" width="38" height="38" alt="Foto">
                        </td>
                        <td>
                            <a href="#" class="fw-bold text-primary text-decoration-none">{{ $alumno->id_alumno }}</a>
                        </td>
                        <td class="fw-semibold text-dark">{{ $alumno->nombre }} {{ $alumno->apellido_p }} {{ $alumno->apellido_m }}</td>
                        <td>{{ $alumno->grado ?? '3°' }}</td>
                        <td>{{ $alumno->grupo ?? 'B' }}</td>
                        <td class="text-muted">{{ $alumno->tutor_nombre ?? 'N/A' }}</td>
                        <td>
                            @if(($alumno->estado ?? 'Activo') === 'Activo')
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">Activo</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('alumnos.show', $alumno->id_alumno) }}" class="btn btn-sm btn-light text-muted rounded-2 me-1"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('alumnos.edit', $alumno->id_alumno) }}" class="btn btn-sm btn-light text-primary rounded-2 me-1"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('alumnos.destroy', $alumno->id_alumno) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger rounded-2" onclick="return confirm('¿Seguro de eliminar este alumno?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">No se encontraron alumnos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginador Footer -->
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top text-muted small">
            <div>Mostrando {{ $alumnos->count() }} alumnos registrados</div>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-item link-secondary page-link rounded-start-3" href="#">Anterior</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link text-dark" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-dark" href="#">3</a></li>
                    <li class="page-item"><a class="page-link text-dark rounded-end-3" href="#">Siguiente</a></li>
                </ul>
            </nav>
        </div>

    </div>
</div>
@endsection