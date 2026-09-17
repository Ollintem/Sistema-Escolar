@extends('layouts.app')

@section('content')
<div class="pt-2 pb-2 mb-4 border-bottom">
    <h1 class="h3 fw-bold text-gray-800">Panel de Control</h1>
    <p class="text-muted mb-0">Resumen general del sistema escolar.</p>
</div>

<!-- Tarjetas Estadísticas -->
<div class="row g-3 mb-4">
    <!-- Ciclo Activo -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 0.75rem;">Ciclo Escolar Activo</h6>
                    <h4 class="fw-bold mb-0">{{ $cicloActivo->nombre ?? 'Ninguno' }}</h4>
                </div>
                <i class="bi bi-calendar-check fs-1 text-white-50"></i>
            </div>
        </div>
    </div>

    <!-- Grupos Registrados -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.75rem;">Total Grupos</h6>
                    <h3 class="fw-bold text-dark mb-0">{{ $totalGrupos }}</h3>
                </div>
                <div class="bg-light p-3 rounded-circle">
                    <i class="bi bi-diagram-3 fs-3 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Alumnos -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.75rem;">Total Alumnos</h6>
                    <h3 class="fw-bold text-dark mb-0">{{ $totalAlumnos }}</h3>
                </div>
                <div class="bg-light p-3 rounded-circle">
                    <i class="bi bi-people fs-3 text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Docentes -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.75rem;">Docentes</h6>
                    <h3 class="fw-bold text-dark mb-0">{{ $totalDocentes }}</h3>
                </div>
                <div class="bg-light p-3 rounded-circle">
                    <i class="bi bi-person-badge fs-3 text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Grupos Recientes -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold mb-0">Últimos Grupos Configurados</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Grupo / Turno</th>
                        <th>Ciclo Escolar</th>
                        <th>Docente Titular</th>
                        <th>Materias</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosGrupos as $grupo)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold text-primary">{{ $grupo->nombre }}</span>
                            <small class="text-muted d-block">{{ $grupo->turno }}</small>
                        </td>
                        <td>{{ $grupo->ciclo->nombre ?? 'N/A' }}</td>
                        <td>{{ $grupo->docenteTitular->nombre ?? 'Sin Titular' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $grupo->materias->count() }} asignadas</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Aún no hay grupos </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection