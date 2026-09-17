<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema Escolar</title>

    <!-- Fonts e Iconos -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div id="app">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm sticky-top">
            <div class="container-fluid px-4">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <i class="bi bi-mortarboard-fill me-2"></i>Sistema Escolar
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login') && !Route::is('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Layout with Sidebar -->
        <div class="container-fluid">
            <div class="row">
                @auth
                <!-- Sidebar Navigability -->
                <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse shadow-sm min-vh-100 p-3">
                    <div class="position-sticky pt-3">
                        <small class="text-uppercase text-muted fw-bold ms-2">Menú Principal</small>
                        <ul class="nav flex-column mt-2">
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ Route::is('home') ? 'active bg-primary text-white' : 'text-dark' }} rounded-3" href="{{ route('home') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ Route::is('ciclos.index') ? 'active bg-primary text-white' : 'text-dark' }} rounded-3" href="{{ route('ciclos.index') }}">
                                    <i class="bi bi-calendar-event me-2"></i>Ciclos Escolares
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ Route::is('alumnos.index') ? 'active bg-primary text-white' : 'text-dark' }} rounded-3" href="{{ route('alumnos.index') }}">
                                    <i class="bi bi-people me-2"></i>Alumnos & Grupos
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ Route::is('docentes.index') ? 'active bg-primary text-white' : 'text-dark' }} rounded-3" href="{{ route('docentes.index') }}">
                                    <i class="bi bi-journal-bookmark me-2"></i>Docentes & Materias
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link {{ Route::is('boletas.index') ? 'active bg-primary text-white' : 'text-dark' }} rounded-3" href="{{ route('boletas.index') }}">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>Boletas & Reportes
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                @endauth

                <!-- Main Content View -->
                <main class="{{ Auth::check() ? 'col-md-9 ms-sm-auto col-lg-10' : 'col-12' }} px-md-4 py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>