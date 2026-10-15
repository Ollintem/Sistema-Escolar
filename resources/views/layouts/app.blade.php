<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema Escolar</title>

    <!-- Tipografía Inter / Fonts e Iconos -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-bg: #0f172a; /* Azul marino oscuro idéntico a Figma */
            --sidebar-hover: #1e293b;
            --sidebar-active: #2563eb; /* Azul eléctrico de selección */
            --bg-main: #f8fafc;
            --font-family: 'Inter', sans-serif;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-main);
            color: #334155;
            margin: 0;
            padding: 0;
        }

        /* Estructura del Layout */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar estilo Figma */
        .sidebar-dark {
            width: 250px;
            background-color: var(--sidebar-bg);
            color: #94a3b8;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-brand {
            padding: 1.25rem 1rem;
            color: #ffffff;
            font-weight: 700;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-menu {
            padding: 0.75rem 0.75rem;
            list-style: none;
            margin: 0;
            overflow-y: auto;
        }

        .sidebar-menu .nav-link {
            color: #94a3b8;
            padding: 0.6rem 0.85rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.2rem;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }

        .sidebar-menu .nav-link:hover {
            color: #ffffff;
            background-color: var(--sidebar-hover);
        }

        .sidebar-menu .nav-link.active {
            color: #ffffff !important;
            background-color: var(--sidebar-active) !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background-color: rgba(0, 0, 0, 0.2);
        }

        /* Área de Contenido Principal */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* Top Header Blanco */
        .top-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .search-box {
            max-width: 360px;
            width: 100%;
            position: relative;
        }

        .search-box input {
            background-color: #f1f5f9;
            border: none;
            border-radius: 20px;
            padding-left: 2.5rem;
            font-size: 0.85rem;
        }

        .card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        @auth
        <!-- Sidebar Oscuro Lateral -->
        <aside class="sidebar-dark">
            <div>
                <!-- Encabezado de Marca -->
                <div class="sidebar-brand d-flex align-items-center gap-2">
                    <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-mortarboard-fill fs-5"></i>
                    </div>
                    <div>
                        <div class="lh-1">Sistema Escolar</div>
                        <small class="text-muted fw-normal fs-7" style="font-size: 0.7rem;">Control Académico</small>
                    </div>
                </div>

                <!-- Lista de Navegación -->
                <ul class="sidebar-menu">
                    <li>
                        <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-grid-1x2-fill"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('ciclos.*') ? 'active' : '' }}" href="{{ route('ciclos.index') }}">
                            <i class="bi bi-calendar-range"></i> Ciclos Escolares
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('grupos.*') ? 'active' : '' }}" href="{{ route('grupos.index') }}">
                            <i class="bi bi-diagram-3-fill"></i> Grupos
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('materias.*') ? 'active' : '' }}" href="{{ route('materias.index') }}">
                            <i class="bi bi-journal-bookmark-fill"></i> Materias
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('alumnos.*') ? 'active' : '' }}" href="{{ route('alumnos.index') }}">
                            <i class="bi bi-people-fill"></i> Alumnos
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('asistencias.*') ? 'active' : '' }}" href="{{ route('asistencias.index') }}">
                            <i class="bi bi-calendar-check-fill"></i> Asistencias
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('calificaciones.*') ? 'active' : '' }}" href="{{ route('calificaciones.index') }}">
                            <i class="bi bi-journal-check"></i> Calificaciones
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('expedientes.*') ? 'active' : '' }}" href="{{ route('expedientes.index') }}">
                            <i class="bi bi-folder-fill"></i> Expedientes
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('boletas.*') ? 'active' : '' }}" href="{{ route('boletas.index') }}">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Boletas
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('personal.empleados*') ? 'active' : '' }}" href="{{ route('personal.empleados') }}">
                            <i class="bi bi-person-workspace"></i> Empleados
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ Route::is('personal.roles*') || Route::is('personal.permisos*') ? 'active' : '' }}" href="{{ route('personal.roles') }}">
                            <i class="bi bi-shield-lock-fill"></i> Roles y Puestos
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Usuario en pie de Sidebar -->
            <div class="sidebar-footer">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2 overflow-hidden">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; flex-shrink: 0;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="lh-1 text-truncate">
                            <div class="text-white fw-semibold small text-truncate">{{ Auth::user()->name }}</div>
                            <small class="text-muted" style="font-size: 0.72rem;">Administrador</small>
                        </div>
                    </div>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-muted text-hover-white ms-2" title="Cerrar Sesión">
                        <i class="bi bi-box-arrow-right fs-5"></i>
                    </a>
                </div>
            </div>
        </aside>
        @endauth

        <!-- Contenido Central -->
        <div class="main-content">
            @auth
            <!-- Barra Superior Navbar Blanca -->
            <header class="top-navbar">
                <div class="search-box d-none d-md-block">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" class="form-control" placeholder="Buscar matrícula, docente...">
                </div>

                <div class="d-flex align-items-center gap-3 ms-auto">
                    <button class="btn btn-light rounded-circle position-relative p-2" type="button">
                        <i class="bi bi-bell text-secondary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>
                    <div class="vr my-2"></div>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle fw-semibold small" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1 fs-5 text-primary"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            @endauth

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>