@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Header Principal -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill fw-bold">
                    <i class="bi bi-mortarboard-fill me-1"></i> Control Escolar
                </span>
            </div>
            <h2 class="fw-bold text-dark mb-1">Gestión de Alumnos</h2>
            <p class="text-muted mb-0">Consulta la lista general de estudiantes, matrículas, asignación de grupos y tutores.</p>
        </div>
        <div>
            <a href="{{ route('alumnos.create') }}" class="btn btn-primary rounded-pill px-4 py-2.5 shadow-sm fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill fs-5"></i> Nuevo Alumno
            </a>
        </div>
    </div>

    <!-- Mensaje de Éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                <div>
                    <strong class="d-block">¡Operación realizada!</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tarjetas de Métricas Rápidas (KPIs) -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-bold d-block mb-1">Total de Alumnos</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ method_exists($alumnos, 'total') ? $alumnos->total() : count($alumnos) }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-bold d-block mb-1">Alumnos Activos</span>
                        <h2 class="fw-bold mb-0 text-dark">
                            {{ method_exists($alumnos, 'total') ? $alumnos->total() : count($alumnos) }}
                        </h2>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-3">
                        <i class="bi bi-person-check-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-info">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-bold d-block mb-1">Inscritos en Ciclo</span>
                        <h2 class="fw-bold mb-0 text-dark">Activo</h2>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded-circle p-3">
                        <i class="bi bi-card-checklist fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Principal con Filtros y Tabla -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <!-- Filtros Rápidos -->
        <div class="card-header bg-white p-4 border-bottom">
            <form method="GET" action="{{ route('alumnos.index') }}" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" name="buscar" class="form-control ps-5 rounded-pill border-0 bg-light" placeholder="Buscar por nombre o matrícula..." value="{{ request('buscar') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="grado" class="form-select rounded-pill border-0 bg-light text-secondary fw-semibold" onchange="this.form.submit()">
                        <option value="">Grado: Todos</option>
                        <option value="1" {{ request('grado') == '1' ? 'selected' : '' }}>1°</option>
                        <option value="2" {{ request('grado') == '2' ? 'selected' : '' }}>2°</option>
                        <option value="3" {{ request('grado') == '3' ? 'selected' : '' }}>3°</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="grupo" class="form-select rounded-pill border-0 bg-light text-secondary fw-semibold" onchange="this.form.submit()">
                        <option value="">Grupo: Todos</option>
                        <option value="A" {{ request('grupo') == 'A' ? 'selected' : '' }}>Grupo A</option>
                        <option value="B" {{ request('grupo') == 'B' ? 'selected' : '' }}>Grupo B</option>
                        <option value="C" {{ request('grupo') == 'C' ? 'selected' : '' }}>Grupo C</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="estado" class="form-select rounded-pill border-0 bg-light text-secondary fw-semibold" onchange="this.form.submit()">
                        <option value="">Estado: Todos</option>
                        <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Inactivo" {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <a href="{{ route('alumnos.index') }}" class="btn btn-light rounded-pill px-3 w-100 fw-semibold text-muted border">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabla de Alumnos -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                        <tr>
                            <th class="ps-4 py-3">FOTO</th>
                            <th class="py-3">NOMBRE COMPLETO</th>
                            <th class="py-3">GRADO</th>
                            <th class="py-3">GRUPO</th>
                            <th class="py-3">TUTOR</th>
                            <th class="py-3">ESTADO</th>
                            <th class="text-end pe-4 py-3">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($alumnos as $alumno)
                        <tr>
                            <td class="ps-4">
                                <img src="{{ $alumno->foto ? asset('storage/'.$alumno->foto) : 'https://ui-avatars.com/api/?name='.urlencode($alumno->nombre.' '.$alumno->apellido_p).'&background=0d6efd&color=fff' }}" 
                                     class="rounded-circle object-fit-cover border shadow-sm" width="40" height="40" alt="Foto Alumno">
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $alumno->nombre }} {{ $alumno->apellido_p }} {{ $alumno->apellido_m }}</div>
                                <small class="text-muted"><i class="bi bi-envelope me-1"></i>{{ $alumno->correo ?? 'Sin correo' }}</small>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">
                                    {{ $alumno->grupo->grado->nombre ?? $alumno->grupo->grado ?? $alumno->grado ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2.5 py-1 rounded-2 fw-semibold">
                                    {{ $alumno->grupo->grupo ?? $alumno->grupo->nombre ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-secondary fs-7"><i class="bi bi-person-heart me-1 text-primary"></i>{{ $alumno->tutor_nombre ?? 'N/A' }}</span>
                            </td>
                            <td>
                                @if(($alumno->estado ?? 'Activo') === 'Activo')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill fw-semibold fs-7">
                                        <i class="bi bi-dot"></i> Activo
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-1 rounded-pill fw-semibold fs-7">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('alumnos.show', $alumno->id_alumno) }}" class="btn btn-sm btn-light text-muted rounded-circle border shadow-sm" title="Ver Expediente">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('alumnos.edit', $alumno->id_alumno) }}" class="btn btn-sm btn-light text-primary rounded-circle border shadow-sm" title="Editar Alumno">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('alumnos.destroy', $alumno->id_alumno) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle border shadow-sm" title="Eliminar" onclick="return confirm('¿Confirmas eliminar a este estudiante?')">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-people fs-1 text-secondary opacity-50 d-block mb-3"></i>
                                <h5>No se encontraron alumnos registrados</h5>
                                <p class="small text-muted mb-0">Comienza haciendo clic en el botón "Nuevo Alumno".</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer / Paginación -->
        <div class="card-footer bg-white py-3 px-4 d-flex flex-column flex-md-row align-items-center justify-content-between border-top text-muted small">
            <div>
                Mostrando <strong class="text-dark">{{ $alumnos->count() }}</strong> estudiantes registrados
            </div>
            <div>
                @if(method_exists($alumnos, 'links'))
                    {{ $alumnos->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .fs-7 {
        font-size: 0.8rem;
    }
</style>
@endsection