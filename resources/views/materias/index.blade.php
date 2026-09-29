@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Header Principal -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill fw-bold">
                    <i class="bi bi-book-half me-1"></i> Plan Académico
                </span>
            </div>
            <h2 class="fw-bold text-dark mb-1">Catálogo de Materias</h2>
            <p class="text-muted mb-0">Gestiona las asignaturas curriculares registradas en la institución.</p>
        </div>
        <div>
            @can('materias.crear')
            <button class="btn btn-primary rounded-pill px-4 py-2.5 shadow-sm fw-bold d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNuevaMateria">
                <i class="bi bi-plus-lg fs-5"></i> Agregar Materia
            </button>
            @endcan
        </div>
    </div>

    <!-- Alert de éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                <div>
                    <strong class="d-block">¡Registro actualizado!</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Barra Superior de Métricas Breves y Filtro -->
    <div class="row align-items-center g-3 mb-4">
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white px-3 py-2 rounded-3 shadow-sm border d-flex align-items-center gap-2">
                    <span class="text-muted small fw-bold text-uppercase">Total:</span>
                    <span class="fw-bold text-primary fs-6">{{ count($materias ?? []) }} materias</span>
                </div>
                <div class="bg-white px-3 py-2 rounded-3 shadow-sm border d-flex align-items-center gap-2">
                    <span class="text-muted small fw-bold text-uppercase">Estatus:</span>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-bold">Activo</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="position-relative ms-auto" style="max-width: 350px;">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" id="filtroMateria" class="form-control ps-5 rounded-pill border-0 shadow-sm" placeholder="Buscar por clave o nombre...">
            </div>
        </div>
    </div>

    <!-- Grid de Tarjetas para las Materias -->
    <div class="row g-3" id="contenedorMaterias">
        @forelse($materias ?? [] as $materia)
        <div class="col-md-6 col-lg-4 tarjeta-materia">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow transition-all bg-white position-relative overflow-hidden">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Clave y Acciones -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="font-monospace bg-light border text-primary fw-bold px-3 py-1 rounded-3 fs-7">
                                # {{ $materia->clave }}
                            </span>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0 text-decoration-none" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                    @can('materias.editar')
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 text-primary" href="#">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                    </li>
                                    @endcan
                                    @can('materias.eliminar')
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>

                        <!-- Nombre e ícono -->
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-4 bg-primary bg-opacity-10 text-primary p-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                                <i class="bi bi-journal-text fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0 nombre-materia">{{ $materia->nombre }}</h5>
                                <small class="text-muted">Asignatura Curricular</small>
                            </div>
                        </div>
                    </div>

                    <!-- Footer de la Tarjeta -->
                    <div class="border-top pt-3 mt-2 d-flex justify-content-between align-items-center text-muted small">
                        <span><i class="bi bi-calendar-event me-1"></i> {{ $materia->created_at ? $materia->created_at->format('d/m/Y') : 'N/A' }}</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Activa</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="bg-white rounded-4 p-5 shadow-sm border d-inline-block">
                <i class="bi bi-journal-x fs-1 text-muted d-block mb-3"></i>
                <h5 class="fw-bold text-dark">No hay materias registradas</h5>
                <p class="text-muted small mb-0">Haz clic en "Agregar Materia" para registrar la primera.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Registrar Nueva Materia -->
<div class="modal fade" id="modalNuevaMateria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4 pb-0">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-journal-plus text-primary"></i> Registrar Materia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('materias.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">CLAVE DE LA MATERIA *</label>
                        <input type="text" name="clave" class="form-control form-control-lg rounded-3 fs-6" placeholder="Ej. MAT-101" required value="{{ old('clave') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">NOMBRE DE LA MATERIA *</label>
                        <input type="text" name="nombre" class="form-control form-control-lg rounded-3 fs-6" placeholder="Ej. Matemáticas I" required value="{{ old('nombre') }}">
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">Guardar Materia</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script de Búsqueda Rápida en Tarjetas -->
<script>
    document.getElementById('filtroMateria')?.addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        let tarjetas = document.querySelectorAll('.tarjeta-materia');
        tarjetas.forEach(tarjeta => {
            let texto = tarjeta.textContent.toLowerCase();
            tarjeta.style.display = texto.includes(filtro) ? '' : 'none';
        });
    });
</script>

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .transition-all {
        transition: all 0.25s ease-in-out;
    }
    .fs-7 {
        font-size: 0.825rem;
    }
</style>
@endsection