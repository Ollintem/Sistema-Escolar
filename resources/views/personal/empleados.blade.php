@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Gestión de Personal</h3>
            <p class="text-muted mb-0">Administra roles, docentes, tutores y administradores</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEmpleado">
            <i class="bi bi-person-plus-fill me-2"></i>+ Agregar Empleado
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        @foreach($roles as $role)
            <div class="col-6 col-md-2">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center bg-white">
                    <small class="text-uppercase fw-bold text-muted" style="font-size: 0.75rem;">{{ $role->name }}</small>
                    <h2 class="fw-bold text-primary my-1">{{ $role->users_count }}</h2>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Lista de Personal</h5>
                <input type="text" id="inputBuscarEmpleado" class="form-control w-25 rounded-pill" placeholder="Buscar empleado...">
            </div>

            <div class="table-responsive">
                <table class="table align-middle" id="tablaEmpleados">
                    <thead class="table-light">
                        <tr class="text-muted small">
                            <th>NOMBRE</th>
                            <th>CORREO</th>
                            <th>TELÉFONO</th>
                            <th>ESPECIALIDAD / PERFIL</th>
                            <th>ROL / PUESTO</th>
                            <th>PERMISOS</th>
                            <th class="text-end">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($empleados as $emp)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($emp->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $emp->name }}</div>
                                            <small class="text-muted">ID: EMP-{{ str_pad($emp->id, 3, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><small class="text-secondary">{{ $emp->email }}</small></td>
                                <td><small class="text-secondary">{{ $emp->telefono ?? 'N/A' }}</small></td>
                                <td>
                                    @if($emp->especialidad)
                                        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-1">
                                            {{ $emp->especialidad }}
                                        </span>
                                    @else
                                        <span class="text-muted small">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1">
                                        {{ $emp->roles->first()->name ?? 'Sin Rol' }}
                                    </span>
                                </td>
                                <td>
                                    @if($emp->roles->first())
                                        <a href="{{ route('personal.permisos', $emp->roles->first()->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                            <i class="bi bi-gear-fill me-1"></i>Configurar
                                        </a>
                                    @else
                                        <span class="text-muted small">N/A</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $emp->id }}" title="Editar">
                                        <i class="bi bi-pencil-fill text-muted"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $emp->id }}" title="Eliminar">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No hay empleados ni docentes registrados aún.</td>
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
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Editar Empleado
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('personal.empleados.update', $emp->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">NOMBRE COMPLETO *</label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ $emp->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">CORREO ELECTRÓNICO *</label>
                                <input type="email" name="email" class="form-control rounded-3" value="{{ $emp->email }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">ROL / PUESTO *</label>
                                <select name="role" class="form-select rounded-3" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $emp->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">TELÉFONO</label>
                                <input type="text" name="telefono" class="form-control rounded-3" value="{{ $emp->telefono }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">ESPECIALIDAD / PERFIL PROFESIONAL</label>
                                <input type="text" name="especialidad" class="form-control rounded-3" value="{{ $emp->especialidad }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-muted">NUEVA CONTRASEÑA (OPCIONAL)</label>
                                <input type="password" name="password" class="form-control rounded-3" placeholder="Dejar en blanco para mantener la actual">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 px-4 pb-4">
                        <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">
                            <i class="bi bi-save me-1"></i> Actualizar
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
                    <i class="bi bi-exclamation-triangle text-danger display-4"></i>
                    <h5 class="fw-bold mt-2">¿Eliminar empleado?</h5>
                    <p class="text-muted small mb-0">Esta acción no se puede deshacer. Se eliminará a <strong>{{ $emp->name }}</strong>.</p>
                </div>
                <div class="d-flex justify-content-center gap-2 pb-2">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('personal.empleados.destroy', $emp->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-3 px-3">Sí, Eliminar</button>
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
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalEmpleadoLabel">
                    <i class="bi bi-person-plus text-primary me-2"></i>Registrar Nuevo Personal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('personal.empleados.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">NOMBRE COMPLETO *</label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="Ej. Roberto Gómez Hernández" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">CORREO ELECTRÓNICO *</label>
                            <input type="email" name="email" class="form-control rounded-3" placeholder="ejemplo@escuela.com" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">ROL / PUESTO *</label>
                            <select name="role" class="form-select rounded-3" required>
                                <option value="" selected disabled>Seleccionar rol...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">TELÉFONO</label>
                            <input type="text" name="telefono" class="form-control rounded-3" placeholder="Ej. 55 1234 5678">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">ESPECIALIDAD / PERFIL PROFESIONAL</label>
                            <input type="text" name="especialidad" class="form-control rounded-3" placeholder="Ej. Lic. en Matemáticas">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">CONTRASEÑA *</label>
                            <input type="password" name="password" class="form-control rounded-3" placeholder="Mínimo 8 caracteres" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">
                        <i class="bi bi-save me-1"></i> Guardar Personal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection