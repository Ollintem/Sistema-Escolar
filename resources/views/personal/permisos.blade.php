@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Gestión de Personal</h3>
        <p class="text-muted mb-0">Configurando permisos para el puesto: <strong class="text-primary">{{ ucfirst($role->name) }}</strong></p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('personal.permisos.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle text-center mb-0">
                        <thead class="table-light">
                            <tr class="text-muted small">
                                <th class="text-start ps-3" style="width: 25%;">MÓDULOS</th>
                                <th>MOSTRAR</th>
                                <th>CREAR</th>
                                <th>EDITAR</th>
                                <th>ELIMINAR</th>
                                <th>GESTIONAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modulos as $key => $nombreModulo)
                                <tr>
                                    <td class="text-start ps-3 fw-bold text-secondary small">
                                        {{ $nombreModulo }}
                                    </td>
                                    @foreach($acciones as $accion)
                                        @php
                                            $permissionName = "{$key}.{$accion}";
                                        @endphp
                                        <td>
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                       name="permissions[]" 
                                                       value="{{ $permissionName }}"
                                                       {{ in_array($permissionName, $rolePermisos) ? 'checked' : '' }}
                                                       style="cursor: pointer; width: 2.2em; height: 1.2em;">
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('personal.roles') }}" class="btn btn-light rounded-3 px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection