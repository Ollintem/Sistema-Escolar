@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Encabezado Principal -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill fw-bold">
                    <i class="bi bi-people-fill me-1"></i> Recursos Humanos
                </span>
            </div>
            <h2 class="fw-bold text-dark mb-1">Gestión de Personal</h2>
            <p class="text-muted mb-0">Administra cuentas de docentes, tutores, administradores y permisos de acceso.</p>
        </div>
        <div>
            <button class="btn btn-primary rounded-pill px-4 py-2.5 shadow-sm fw-bold d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalEmpleado">
                <i class="bi bi-person-plus-fill fs-5"></i> Agregar Empleado
            </button>
        </div>
    </div>

    <!-- Alertas del Sistema -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                <div>
                    <strong class="d-block">¡Operación Exitosa!</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                <div>
                    <strong class="d-block">Error en la solicitud:</strong>
                    <span class="small">{{ session('error') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-x-circle-fill fs-4 me-3 text-danger"></i>
                <div>
                    <strong class="d-block">Por favor revisa los campos:</strong>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tarjetas de Conteo por Rol (KPIs) -->
    <div class="row g-3 mb-4">
        @foreach($roles as $role)
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-primary">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fs-7 text-uppercase fw-bold d-block mb-1">{{ $role->name }}</span>
                            <h2 class="fw-bold mb-0 text-dark">{{ $role->users_count }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                            @if(strtolower($role->name) == 'admin' || strtolower($role->name) == 'administrador')
                                <i class="bi bi-shield-lock-fill fs-3"></i>
                            @elseif(strtolower($role->name) == 'docente')
                                <i class="bi bi-person-workspace fs-3"></i>
                            @elseif(strtolower($role->name) == 'tutor')
                                <i class="bi bi-person-heart fs-3"></i>
                            @else
                                <i class="bi bi-person-badge-fill fs-3"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tabla Principal de Personal -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 border-bottom">
            <h6 class="fw-bold mb-0 text-secondary"><i class="bi bi-people me-2"></i>Lista de Personal Registrado</h6>
            <div class="position-relative" style="max-width: 320px;">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" id="inputBuscarEmpleado" class="form-control ps-5 rounded-pill border-0 bg-light" placeholder="Buscar por nombre, correo, rol...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="tablaEmpleados">
                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                        <tr>
                            <th class="ps-4 py-3">NOMBRE</th>
                            <th class="py-3">CORREO</th>
                            <th class="py-3">TELÉFONO</th>
                            <th class="py-3">ESPECIALIDAD / PERFIL</th>
                            <th class="py-3">ROL / PUESTO</th>
                            <th class="py-3">PERMISOS</th>
                            <th class="text-end pe-4 py-3">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($empleados as $emp)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold fs-6 shadow-sm" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($emp->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $emp->name }}</div>
                                        <span class="badge bg-light text-muted border font-monospace fs-7">
                                            EMP-{{ str_pad($emp->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary fs-7"><i class="bi bi-envelope me-1"></i>{{ $emp->email }}</span>
                            </td>
                            <td>
                                <span class="text-secondary fs-7"><i class="bi bi-telephone me-1"></i>{{ $emp->telefono ?? 'N/A' }}</span>
                            </td>
                            <td>
                                @if($emp->especialidad)
                                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-1 fw-semibold fs-7">
                                        {{ $emp->especialidad }}
                                    </span>
                                @else
                                    <span class="text-muted fs-7">Sin definir</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-bold fs-7">
                                    {{ $emp->roles->first()->name ?? 'Sin Rol' }}
                                </span>
                            </td>
                            <td>
                                @if($emp->roles->first())
                                    <a href="{{ route('personal.permisos', $emp->roles->first()->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm fw-semibold">
                                        <i class="bi bi-gear-fill me-1 text-primary"></i> Configurar
                                    </a>
                                @else
                                    <span class="text-muted fs-7">N/A</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group gap-1">
                                    <button class="btn btn-sm btn-light text-primary rounded-circle border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $emp->id }}" title="Editar Empleado">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light text-danger rounded-circle border shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $emp->id }}" title="Eliminar Empleado">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-people fs-1 text-secondary opacity-50 d-block mb-3"></i>
                                <h5>No se encontraron empleados ni docentes</h5>
                                <p class="small text-muted mb-0">Presiona el botón "Agregar Empleado" para hacer un nuevo registro.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODALES DE EDICIÓN Y ELIMINACIÓN -->
@foreach($empleados as $emp)
    <!-- MODAL EDITAR EMPLEADO -->
    <div class="modal fade" id="modalEditar{{ $emp->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 text-start">
                <div class="modal-header border-bottom-0 p-4 pb-0">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square text-primary"></i> Editar Información de Personal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('personal.empleados.update', $emp->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small">NOMBRE COMPLETO *</label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ $emp->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small">CORREO ELECTRÓNICO *</label>
                                <input type="email" name="email" class="form-control rounded-3" value="{{ $emp->email }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small">ROL / PUESTO *</label>
                                <select name="role" class="form-select rounded-3" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $emp->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small">TELÉFONO</label>
                                <input type="text" name="telefono" class="form-control rounded-3" value="{{ $emp->telefono }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small">ESPECIALIDAD / PERFIL</label>
                                <input type="text" name="especialidad" class="form-control rounded-3" value="{{ $emp->especialidad }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary small">NUEVA CONTRASEÑA (OPCIONAL)</label>
                                <input type="password" name="password" class="form-control rounded-3" placeholder="Dejar en blanco para mantener actual">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                            <i class="bi bi-check-lg me-1"></i> Actualizar Personal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL CONFIRMAR ELIMINACIÓN -->
    <div class="modal fade" id="modalEliminar{{ $emp->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg rounded-4 text-center p-3">
                <div class="modal-body">
                    <i class="bi bi-exclamation-triangle text-danger display-4 d-block mb-2"></i>
                    <h5 class="fw-bold">¿Eliminar empleado?</h5>
                    <p class="text-muted small mb-0">Esta acción no se puede deshacer. Se eliminará el registro de <strong>{{ $emp->name }}</strong>.</p>
                </div>
                <div class="d-flex justify-content-center gap-2 pb-2">
                    <button type="button" class="btn btn-light rounded-pill px-3 fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('personal.empleados.destroy', $emp->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-3 fw-semibold">Sí, Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- MODAL REGISTRAR EMPLEADO -->
<div class="modal fade" id="modalEmpleado" tabindex="-1" aria-labelledby="modalEmpleadoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4 pb-0">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="modalEmpleadoLabel">
                    <i class="bi bi-person-plus text-primary"></i> Registrar Nuevo Personal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('personal.empleados.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">NOMBRE COMPLETO *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control rounded-end-3 border-start-0" placeholder="Ej. Roberto Gómez Hernández" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">CORREO ELECTRÓNICO *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control rounded-end-3 border-start-0" placeholder="ejemplo@escuela.com" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">ROL / PUESTO *</label>
                            <select name="role" class="form-select rounded-3" required>
                                <option value="" selected disabled>Seleccionar rol...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">TELÉFONO</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="telefono" class="form-control rounded-end-3 border-start-0" placeholder="Ej. 55 1234 5678">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">ESPECIALIDAD / PERFIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-mortarboard"></i></span>
                                <input type="text" name="especialidad" class="form-control rounded-end-3 border-start-0" placeholder="Ej. Lic. en Sistemas">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">CONTRASEÑA *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" class="form-control rounded-end-3 border-start-0" placeholder="Mínimo 8 caracteres" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                        <i class="bi bi-check-lg me-1"></i> Guardar Personal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script de Búsqueda Rápida de Personal -->
<script>
    document.getElementById('inputBuscarEmpleado')?.addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        let filas = document.querySelectorAll('#tablaEmpleados tbody tr');
        filas.forEach(fila => {
            let texto = fila.textContent.toLowerCase();
            fila.style.display = texto.includes(filtro) ? '' : 'none';
        });
    });
</script>

<style>
    .fs-7 {
        font-size: 0.8rem;
    }
</style>
@endsection