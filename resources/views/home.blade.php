@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-4 border-bottom">
    <h1 class="h3 fw-bold text-gray-800">Dashboard Administrativo</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill">
            <i class="bi bi-shield-lock-fill me-1"></i> Rol: Administrador
        </span>
    </div>
</div>

<!-- Tarjetas de Acceso Rápido (Métricas del Sistema Escolar) -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white-50 small mb-1">Ciclo Activo</h6>
                    <h4 class="fw-bold mb-0">2026 - 2027</h4>
                </div>
                <i class="bi bi-calendar3 fs-1 text-white-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small mb-1">Alumnos Inscritos</h6>
                    <h4 class="fw-bold text-dark mb-0">0</h4>
                </div>
                <i class="bi bi-mortarboard fs-1 text-success"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small mb-1">Docentes Activos</h6>
                    <h4 class="fw-bold text-dark mb-0">0</h4>
                </div>
                <i class="bi bi-person-badge fs-1 text-warning"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 border-start border-4 border-danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small mb-1">Expedientes Incompletos</h6>
                    <h4 class="fw-bold text-dark mb-0">0</h4>
                </div>
                <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
            </div>
        </div>
    </div>
</div>

<!-- Contenido del Panel Principal -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-2">¡Bienvenido al Sistema de Control Escolar!</h5>
                <p class="text-muted mb-0">
                    Desde este panel podrás gestionar la estructura académica, consultar alertas de expedientes, asignar grupos a los profesores y supervisar las calificaciones del ciclo.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection