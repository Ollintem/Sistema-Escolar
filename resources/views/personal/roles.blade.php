@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Catálogo de Puestos</h3>
            <p class="text-muted">Administra los niveles de acceso para el personal</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalPuesto">
            + Nuevo Puesto
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold mb-3">Puestos Activos</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted small">
                        <th>PUESTO</th>
                        <th class="text-center">EMPLEADOS</th>
                        <th class="text-end">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td class="fw-bold">👤 {{ $role->name }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill px-3 py-2">{{ $role->users_count }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('personal.permisos', $role->id) }}" class="btn btn-sm btn-light rounded-circle">✏️</a>
                                <button class="btn btn-sm btn-light text-danger rounded-circle">🗑️</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Crear Puesto Nuevo -->
<div class="modal fade" id="modalPuesto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Crear Puesto Nuevo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('personal.roles.store') }}" method="POST">
                @csrf
                <div class="modal-body border-0">
                    <label class="form-label small text-muted text-uppercase fw-bold">Nombre del Puesto</label>
                    <input type="text" name="name" class="form-control form-control-lg bg-light border-0 rounded-3" placeholder="Ej: Guardia Nocturno" required>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-primary px-4">💾 Guardar Puesto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection