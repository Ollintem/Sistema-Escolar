@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado de Bienvenida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white shadow-sm border-0 rounded-3">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="fw-bold mb-1">¡Bienvenido(a), {{ Auth::user()->name }}!</h2>
                        <p class="mb-0 opacity-75">
                            Panel de control principal del Sistema Escolar.
                        </p>
                    </div>
                    <div class="d-none d-md-block">
                        <span class="badge bg-light text-primary fs-6 px-3 py-2 rounded-pill shadow-sm">
                            Rol: {{ Auth::user()->getRoleNames()->first() ?? 'Sin Rol' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicador de Ciclo Activo -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3 bg-light">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-check text-success fs-3 me-3"></i>
                        <div>
                            <h6 class="mb-0 text-muted small text-uppercase fw-bold">Ciclo Escolar Activo</h6>
                            <span class="fw-bold fs-5 text-dark">
                                {{ $cicloActivo ? $cicloActivo->nombre : 'No hay ciclo activo registrado' }}
                            </span>
                        </div>
                    </div>
                    @can('ciclos_escolares.mostrar')
                    <a href="{{ route('ciclos.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                        Ver Ciclos
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Métricas Estadísticas -->
    <div class="row g-3 mb-4">
        <!-- Tarjeta Alumnos -->
        @can('alumnos.mostrar')
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-3 me-3">
                        <i class="bi bi-people-fill fs-2"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small text-uppercase mb-1 fw-bold">Alumnos</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalAlumnos }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <!-- Tarjeta Grupos -->
        @can('grupos.mostrar')
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 bg-info bg-opacity-10 text-info p-3 me-3">
                        <i class="bi bi-diagram-3-fill fs-2"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small text-uppercase mb-1 fw-bold">Grupos</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalGrupos }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <!-- Tarjeta Docentes / Personal -->
        @can('empleados.mostrar')
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 bg-warning bg-opacity-10 text-warning p-3 me-3">
                        <i class="bi bi-person-badge-fill fs-2"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small text-uppercase mb-1 fw-bold">Docentes</h6>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalDocentes }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <!-- Tarjeta Accesos / Reportes -->
        @can('boletas_reportes.mostrar')
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 bg-success bg-opacity-10 text-success p-3 me-3">
                        <i class="bi bi-file-earmark-bar-graph-fill fs-2"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small text-uppercase mb-1 fw-bold">Boletas</h6>
                        <a href="{{ route('boletas.index') }}" class="text-decoration-none fw-bold small">
                            Ir a Reportes &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>

    <!-- Sección de Últimos Grupos (Si tiene acceso a Grupos) -->
    @can('grupos.mostrar')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark">Últimos Grupos Registrados</h5>
                    <a href="{{ route('grupos.index') }}" class="btn btn-sm btn-light rounded-pill">Ver Todos</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Grupo / Grado</th>
                                <th>Ciclo Escolar</th>
                                <th>Docente Titular</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosGrupos as $grupo)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">
                                    {{ $grupo->grado ?? '' }} {{ $grupo->nombre ?? $grupo->grupo }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                        {{ $grupo->ciclo->nombre ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $grupo->docenteTitular->nombre ?? 'Sin Asignar' }}
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('grupos.index') }}" class="btn btn-sm btn-outline-primary rounded-circle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No hay grupos registrados recientemente.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection