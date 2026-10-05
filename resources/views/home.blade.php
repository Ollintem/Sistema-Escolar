@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Banner de Bienvenida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                <div class="card-body p-4 p-md-5 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <span class="badge bg-white bg-opacity-20 text-white px-3 py-2 rounded-pill fw-bold mb-2">
                                <i class="bi bi-shield-check me-1"></i> Sesión Activa
                            </span>
                            <h1 class="fw-bold mb-2 display-6">¡Bienvenido(a), {{ Auth::user()->name }}!</h1>
                            <p class="mb-0 opacity-85 fs-6">
                                Panel de administración principal del Sistema Escolar. Controla grupos, matrículas, calificaciones, expedientes y personal educativo desde aquí.
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex flex-column align-items-md-end justify-content-center">
                            <div class="bg-white text-primary rounded-4 px-4 py-3 shadow-sm d-inline-block text-start">
                                <small class="text-uppercase fw-bold text-muted d-block fs-7">Rol Asignado</small>
                                <span class="fw-bold fs-6 text-dark d-flex align-items-center gap-2">
                                    <i class="bi bi-person-badge text-primary"></i>
                                    {{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'Sin Rol') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicador de Ciclo Activo -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-4 border-success">
                <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between py-3 px-4 gap-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                            <i class="bi bi-calendar-check-fill fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted fs-7 text-uppercase fw-bold d-block">Ciclo Escolar Activo</span>
                            <h4 class="fw-bold mb-0 text-dark font-monospace">
                                {{ $cicloActivo ? $cicloActivo->nombre : 'Sin ciclo activo registrado' }}
                            </h4>
                        </div>
                    </div>
                    <div>
                        @can('ciclos_escolares.mostrar')
                        <a href="{{ route('ciclos.index') }}" class="btn btn-outline-success rounded-pill px-4 fw-semibold shadow-sm">
                            <i class="bi bi-arrow-right-circle me-1"></i> Gestionar Ciclos
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Métricas / KPIs -->
    <div class="row g-3 mb-4">
        <!-- Tarjeta Alumnos -->
        @can('alumnos.mostrar')
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white border-start border-4 border-primary">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-bold d-block mb-1">Alumnos</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalAlumnos ?? 0 }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                        <i class="bi bi-people-fill fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <!-- Tarjeta Grupos -->
        @can('grupos.mostrar')
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white border-start border-4 border-info">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-bold d-block mb-1">Grupos</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalGrupos ?? 0 }}</h2>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded-circle p-3">
                        <i class="bi bi-diagram-3-fill fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <!-- Tarjeta Alertas Expedientes Incompletos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white border-start border-4 border-danger">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-bold d-block mb-1">Expedientes Pendientes</span>
                        <h2 class="fw-bold mb-0 text-danger">{{ $expedientesIncompletosCount ?? 0 }}</h2>
                        <a href="{{ route('expedientes.index') }}" class="small text-danger fw-semibold text-decoration-none">
                            Ver Expedientes <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-3">
                        <i class="bi bi-folder-x fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta Acceso a Calificaciones -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white border-start border-4 border-success">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-bold d-block mb-1">Calificaciones</span>
                        <a href="{{ route('calificaciones.index') }}" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold mt-1">
                            Capturar <i class="bi bi-award-fill ms-1"></i>
                        </a>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-3">
                        <i class="bi bi-journal-check fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas de Expedientes Incompletos (Resumen) -->
    @if(isset($expedientesIncompletos) && count($expedientesIncompletos) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden border-start border-4 border-danger">
                <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
                    <h6 class="fw-bold mb-0 text-danger d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill"></i> Alerta de Control Escolar: Alumnos con Documentación Pendiente
                    </h6>
                    <a href="{{ route('expedientes.index') }}" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">Atender Todos</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="bg-light text-muted small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 py-3">ALUMNO</th>
                                <th class="py-3">GRADO / GRUPO</th>
                                <th class="py-3">DOCUMENTOS PENDIENTES</th>
                                <th class="text-end pe-4 py-3">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expedientesIncompletos as $alumnoPendiente)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fw-bold text-dark">{{ $alumnoPendiente->nombre }} {{ $alumnoPendiente->apellido_p }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2.5 py-1 rounded-2">
                                        {{ $alumnoPendiente->grado->nombre ?? '' }} {{ $alumnoPendiente->grupo->grupo ?? '' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-3 py-1 rounded-pill fw-semibold">
                                        <i class="bi bi-file-earmark-x me-1"></i> Expediente Incompleto
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('expedientes.show', $alumnoPendiente->id_alumno) }}" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">
                                        <i class="bi bi-upload me-1"></i> Subir Documentos
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Sección de Últimos Grupos -->
    @can('grupos.mostrar')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
                    <h6 class="fw-bold mb-0 text-secondary"><i class="bi bi-clock-history me-2"></i>Últimos Grupos Registrados</h6>
                    <a href="{{ route('grupos.index') }}" class="btn btn-sm btn-light rounded-pill px-3 fw-semibold border">Ver Todos</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="bg-light text-muted small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 py-3">GRUPO / GRADO</th>
                                <th class="py-3">CICLO ESCOLAR</th>
                                <th class="py-3">DOCENTE TITULAR</th>
                                <th class="text-end pe-4 py-3">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($ultimosGrupos ?? [] as $grupo)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-7" style="width: 34px; height: 34px;">
                                            <i class="bi bi-diagram-3"></i>
                                        </div>
                                        <span class="fw-bold text-dark fs-6">
                                            {{ $grupo->grado->nombre ?? $grupo->grado }} - {{ $grupo->nombre ?? $grupo->grupo }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-1.5 rounded-pill font-monospace">
                                        {{ $grupo->ciclo->nombre ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($grupo->docenteTitular)
                                        <span class="fw-semibold text-dark"><i class="bi bi-person me-1 text-muted"></i>{{ $grupo->docenteTitular->name ?? $grupo->docenteTitular->nombre }}</span>
                                    @else
                                        <span class="badge bg-light text-muted border px-2.5 py-1 rounded-2">Sin Asignar</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group gap-1">
                                        <a href="{{ route('calificaciones.index', ['id_grupo' => $grupo->id_grupo]) }}" class="btn btn-sm btn-light text-success rounded-circle border shadow-sm" title="Capturar Calificaciones">
                                            <i class="bi bi-award-fill"></i>
                                        </a>
                                        <a href="{{ route('grupos.index') }}" class="btn btn-sm btn-light text-primary rounded-circle border shadow-sm" title="Ver Detalle">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 text-secondary opacity-50 d-block mb-2"></i>
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

<style>
    .fs-7 {
        font-size: 0.8rem;
    }
</style>
@endsection