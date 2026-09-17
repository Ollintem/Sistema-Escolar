@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center pt-2 pb-2 mb-4 border-bottom">
    <h1 class="h3 fw-bold text-gray-800">Gestión de Ciclos Escolares</h1>
    <button class="btn btn-primary rounded-3"><i class="bi bi-plus-lg me-1"></i> Nuevo Ciclo</button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4 text-center py-5">
        <i class="bi bi-calendar-check fs-1 text-muted"></i>
        <h5 class="fw-bold mt-3">Task 2.1: Estructura Académica</h5>
        <p class="text-muted mb-0">Aquí podrás aperturar y cerrar los ciclos escolares del sistema.</p>
    </div>
</div>
@endsection