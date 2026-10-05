@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Encabezado y Buscador -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Expedientes de Alumnos</h3>
            <p class="text-muted small mb-0">Gestiona la documentación y estado del expediente de la matrícula escolar.</p>
        </div>
        <div>
            <form action="{{ route('expedientes.index') }}" method="GET" class="d-flex gap-2">
                <div class="input-group shadow-sm rounded-pill bg-white border overflow-hidden">
                    <span class="input-group-text bg-white border-0 ps-3 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="buscar" class="form-control border-0 shadow-none ps-2" placeholder="Buscar por nombre" value="{{ request('buscar') }}" style="min-width: 250px;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 m-1 fw-bold">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tarjetas de Resumen (KPIs) -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block mb-1">Total Alumnos</span>
                        <h3 class="fw-bold text-dark mb-0">{{ $alumnos->total() }}</h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block mb-1">Expedientes Completos</span>
                        <h3 class="fw-bold text-success mb-0">
                            {{ $alumnos->filter(fn($a) => $a->documentos->count() >= 4)->count() }}
                        </h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-folder-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small d-block mb-1">Pendientes / Incompletos</span>
                        <h3 class="fw-bold text-danger mb-0">
                            {{ $alumnos->filter(fn($a) => $a->documentos->count() < 4)->count() }}
                        </h3>
                    </div>
                    <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla Principal con Estilo Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light bg-opacity-50 text-uppercase text-muted small fw-bold border-bottom">
                    <tr>
                        <th class="ps-4 py-3">Alumno</th>
                        <th class="py-3">Grado y Grupo</th>
                        <th class="py-3 text-center" style="min-width: 160px;">Avance Documentos</th>
                        <th class="py-3 text-center">Estado</th>
                        <th class="py-3 text-end pe-4">Acción</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($alumnos as $alumno)
                        @php
                            $docsSubidosCount = $alumno->documentos->count();
                            $totalRequeridos = 4;
                            $porcentaje = min(100, round(($docsSubidosCount / $totalRequeridos) * 100));
                            $completo = $docsSubidosCount >= $totalRequeridos;
                        @endphp
                        <tr>
                            <!-- Alumno y Avatar -->
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 45px; height: 45px;" class="flex-shrink-0">
                                        @if(!empty($alumno->foto) && Storage::disk('public')->exists($alumno->foto))
                                            <img src="{{ asset('storage/' . $alumno->foto) }}" class="rounded-circle object-fit-cover w-100 h-100 shadow-sm border">
                                        @else
                                            <div class="w-100 h-100 rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold border border-primary-subtle">
                                                {{ strtoupper(substr($alumno->nombre, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ strtoupper($alumno->nombre) }} {{ strtoupper($alumno->apellido_p) }} {{ strtoupper($alumno->apellido_m) }}</div>
                                        <div class="small text-muted font-monospace">{{ $alumno->curp ?? 'Matrícula #' . $alumno->id_alumno }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Grado y Grupo -->
                            <td class="py-3">
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-3 fw-semibold">
                                    @if($alumno->grupo)
                                        {{ $alumno->grupo->nombre ?? $alumno->grupo->grado ?? 'Grupo' }} - {{ $alumno->grupo->clave ?? $alumno->grupo->grupo ?? $alumno->grupo->id_grupo }}
                                    @else
                                        Sin Grupo
                                    @endif
                                </span>
                            </td>

                            <!-- Barra de Progreso -->
                            <td class="py-3 text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                    <span class="small fw-bold text-dark">{{ $docsSubidosCount }} / {{ $totalRequeridos }}</span>
                                    <span class="small text-muted">({{ $porcentaje }}%)</span>
                                </div>
                                <div class="progress rounded-pill bg-light mx-auto" style="height: 6px; max-width: 130px;">
                                    <div class="progress-bar rounded-pill {{ $completo ? 'bg-success' : ($porcentaje > 0 ? 'bg-warning' : 'bg-danger') }}" 
                                         role="progressbar" 
                                         style="width: {{ $porcentaje }}%;"></div>
                                </div>
                            </td>

                            <!-- Estado -->
                            <td class="py-3 text-center">
                                @if($completo)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-3 py-2 fw-bold">
                                        <i class="bi bi-check-circle-fill me-1"></i> Completo
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle rounded-pill px-3 py-2 fw-bold">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i> Incompleto
                                    </span>
                                @endif
                            </td>

                            <!-- Botón Acción -->
                            <td class="py-3 text-end pe-4">
                                <a href="{{ route('expedientes.show', $alumno->id_alumno) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold border-1">
                                    Ver Expediente <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                                No se encontraron expedientes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($alumnos->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-end">
                {{ $alumnos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection