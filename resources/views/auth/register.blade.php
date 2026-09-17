@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-sm-5">
                    
                    {{-- Encabezado / Logo --}}
                    <div class="text-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-plus-fill fs-2"></i>
                        </div>
                        <h3 class="fw-bold text-dark">Crear Cuenta</h3>
                        <p class="text-muted small">Ingresa tus datos para registrarte en el sistema</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Nombre --}}
                        <div class="form-floating mb-3">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre completo">
                            <label for="name">Nombre Completo</label>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Correo Electrónico --}}
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nombre@ejemplo.com">
                            <label for="email">Correo Electrónico</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Contraseña --}}
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña">
                            <label for="password">Contraseña</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Confirmar Contraseña --}}
                        <div class="form-floating mb-4">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Contraseña">
                            <label for="password-confirm">Confirmar Contraseña</label>
                        </div>

                        {{-- Botón de Registro --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold fs-6">
                                Registrarse
                            </button>
                        </div>

                        {{-- Enlace a Login --}}
                        <div class="text-center mt-3">
                            <span class="text-secondary small">¿Ya tienes una cuenta?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none small text-primary fw-semibold ms-1">Inicia sesión</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection