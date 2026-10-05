<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Sistema Escolar</title>

    <!-- Fonts e Iconos -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>
</head>
<body class="bg-light">
    <div id="app">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm sticky-top">
            <div class="container-fluid px-4">
                <a class="navbar-brand fw-bold" href="<?php echo e(url('/')); ?>">
                    <i class="bi bi-mortarboard-fill me-2"></i>Sistema Escolar
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('login') && !Route::is('login')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('login')); ?>">Iniciar Sesión</a>
                                </li>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-1"></i> <?php echo e(Auth::user()->name); ?>

                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Layout with Sidebar -->
        <div class="container-fluid">
            <div class="row">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <!-- Sidebar Navigation -->
                <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse shadow-sm min-vh-100 p-3">
                    <div class="position-sticky pt-3">
                        
                        <!-- MENÚ PRINCIPAL -->
                        <small class="text-uppercase text-muted fw-bold ms-2">Menú Principal</small>
                        <ul class="nav flex-column mt-2 mb-3">
                            <!-- Dashboard -->
                            <li class="nav-item mb-1">
                                <a class="nav-link <?php echo e(Route::is('home') ? 'active bg-primary text-white' : 'text-dark'); ?> rounded-3" href="<?php echo e(route('home')); ?>">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a>
                            </li>

                            <!-- Módulo 1 - Ciclos Escolares -->
                            <li class="nav-item mb-1">
                                <a class="nav-link <?php echo e(Route::is('ciclos.*') ? 'active bg-primary text-white' : 'text-dark'); ?> rounded-3" href="<?php echo e(route('ciclos.index')); ?>">
                                    <i class="bi bi-calendar-event me-2"></i>Ciclos Escolares
                                </a>
                            </li>

                            <!-- Módulo 2 - Grupos -->
                            <li class="nav-item mb-1">
                                <a class="nav-link <?php echo e(Route::is('grupos.*') ? 'active bg-primary text-white' : 'text-dark'); ?> rounded-3" href="<?php echo e(route('grupos.index')); ?>">
                                    <i class="bi bi-diagram-3 me-2"></i>Grupos
                                </a>
                            </li>

                            <!-- Alumnos -->
                            <li class="nav-item mb-1">
                                <a class="nav-link <?php echo e(Route::is('alumnos.*') ? 'active bg-primary text-white' : 'text-dark'); ?> rounded-3" href="<?php echo e(route('alumnos.index')); ?>">
                                    <i class="bi bi-people me-2"></i>Alumnos
                                </a>
                            </li>

                            <!-- Materias -->
                            <li class="nav-item mb-1">
                                <a class="nav-link <?php echo e(Route::is('materias.*') ? 'active bg-primary text-white' : 'text-dark'); ?> rounded-3" href="<?php echo e(route('materias.index')); ?>">
                                    <i class="bi bi-journal-bookmark me-2"></i>Materias
                                </a>
                            </li>

                            <!-- Boletas -->
                            <li class="nav-item mb-1">
                                <a class="nav-link <?php echo e(Route::is('boletas.*') ? 'active bg-primary text-white' : 'text-dark'); ?> rounded-3" href="<?php echo e(route('boletas.index')); ?>">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>Boletas & Reportes
                                </a>
                            </li>

                            <!-- Empleados -->
                            <li class="nav-item mb-1">
                                <a class="nav-link <?php echo e(Route::is('personal.empleados*') ? 'active bg-primary text-white' : 'text-dark'); ?> rounded-3" href="<?php echo e(route('personal.empleados')); ?>">
                                    <i class="bi bi-person-workspace me-2"></i>Empleados
                                </a>
                            </li>

                            <!-- Roles y Puestos -->
                            <li class="nav-item mb-1">
                                <a class="nav-link <?php echo e(Route::is('personal.roles*') || Route::is('personal.permisos*') ? 'active bg-primary text-white' : 'text-dark'); ?> rounded-3" href="<?php echo e(route('personal.roles')); ?>">
                                    <i class="bi bi-shield-lock me-2"></i>Roles y Puestos
                                </a>
                            </li>

                            <!-- Calificaciones -->
                            <li class="nav-item">
                                <a href="<?php echo e(route('calificaciones.index')); ?>" class="nav-link <?php echo e(request()->routeIs('calificaciones.*') ? 'active' : ''); ?>">
                                    <i class="bi bi-journal-check me-2"></i> Calificaciones
                                </a>
                            </li>
                        </ul>

                    </div>
                </nav>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Main Content View -->
                <main class="<?php echo e(Auth::check() ? 'col-md-9 ms-sm-auto col-lg-10' : 'col-12'); ?> px-md-4 py-4">
                    <?php echo $__env->yieldContent('content'); ?>
                </main>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\Natt\Documents\Proyecto Sis\sistema-escolar\resources\views/layouts/app.blade.php ENDPATH**/ ?>