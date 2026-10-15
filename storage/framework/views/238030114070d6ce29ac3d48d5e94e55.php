<?php $__env->startSection('content'); ?>
<style>
    /* Tipografía y estilos base */
    body {
        background-color: #f8fafc;
        color: #1e293b;
    }
    
    /* Breadcrumb y encabezado */
    .breadcrumb-text {
        font-size: 0.85rem;
        color: #64748b;
    }
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.25rem;
    }
    .page-subtitle {
        color: #64748b;
        font-size: 0.9rem;
    }

    /* Cards de métricas superiores (KPIs) */
    .card-kpi {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        height: 100%;
    }
    .kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .kpi-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 0.25rem;
    }
    .kpi-value {
        font-size: 1.65rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.1;
    }
    .kpi-subtext {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 0.35rem;
    }

    /* Widget de alertas de expedientes lateral */
    .alert-item-red {
        background-color: #fef2f2;
        border-radius: 12px;
        padding: 0.85rem 1rem;
        margin-bottom: 0.65rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .alert-name {
        font-weight: 700;
        font-size: 0.875rem;
        color: #1e293b;
        margin-bottom: 0.1rem;
    }
    .alert-desc {
        font-size: 0.775rem;
        color: #dc3545;
    }

    /* Tablas estilo Figma */
    .table-figma th {
        background-color: #f8fafc;
        color: #64748b;
        font-size: 0.75rem;
        text-transform: capitalize;
        font-weight: 600;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
    }
    .table-figma td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
    }
</style>

<div class="container-fluid px-3 py-2">

    <!-- Breadcrumb -->
    <div class="breadcrumb-text mb-2">
        <span>Sistema Escolar</span> <span class="mx-1">/</span> <strong class="text-dark">Dashboard</strong>
    </div>

    <!-- Título de Bienvenido -->
    <div class="mb-4">
        <h2 class="page-title">Bienvenido, <?php echo e(Auth::user()->name); ?></h2>
        <p class="page-subtitle mb-0">Resumen general del estado escolar para el ciclo lectivo vigente.</p>
    </div>

    <!-- 1. Grid Superior: 4 Métricas Clave -->
    <div class="row g-3 mb-4">
        <!-- Total Alumnos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-kpi d-flex align-items-center gap-3">
                <div class="kpi-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="kpi-title">Total Alumnos</div>
                    <div class="kpi-value"><?php echo e($totalAlumnos ?? 0); ?></div>
                    <div class="kpi-subtext text-success">+3.2% este mes</div>
                </div>
            </div>
        </div>

        <!-- Docentes Activos (Desde la tabla Users) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-kpi d-flex align-items-center gap-3">
                <div class="kpi-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-mortarboard"></i>
                </div>
                <div>
                    <div class="kpi-title">Docentes Activos</div>
                    <div class="kpi-value"><?php echo e($totalDocentes ?? 0); ?></div>
                    <div class="kpi-subtext">Docentes registrados</div>
                </div>
            </div>
        </div>

        <!-- Grupos Activos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-kpi d-flex align-items-center gap-3">
                <div class="kpi-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <div>
                    <div class="kpi-title">Grupos Activos</div>
                    <div class="kpi-value"><?php echo e($totalGrupos ?? 0); ?></div>
                    <div class="kpi-subtext text-primary">Grupos registrados</div>
                </div>
            </div>
        </div>

        <!-- Ciclo Actual -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card-kpi d-flex align-items-center gap-3">
                <div class="kpi-icon bg-secondary bg-opacity-10 text-dark">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div>
                    <div class="kpi-title">Ciclo Actual</div>
                    <div class="kpi-value fs-5"><?php echo e($cicloActivo ? ($cicloActivo->nombre ?? $cicloActivo->ciclo) : 'Sin Activo'); ?></div>
                    <div class="kpi-subtext">Fase de Evaluación</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Bloque Principal: Últimos Grupos / Registros (Izquierda) + Alertas de Expedientes (Derecha) -->
    <div class="row g-4">
        <!-- Tabla de Últimos Grupos (Columna Izquierda 8/12) -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100">
                <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom-0">
                    <h5 class="fw-bold mb-0 text-dark fs-6">Grupos Recientes</h5>
                    <a href="<?php echo e(route('grupos.index')); ?>" class="text-primary text-decoration-none fw-semibold small">Ver Todos</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-figma align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nombre Grupo / Grado</th>
                                <th>Ciclo Escolar</th>
                                <th>Docente Titular</th>
                                <th class="text-end pe-4">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $ultimosGrupos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="fw-semibold text-dark">
                                    <?php echo e($grupo->grado->nombre ?? $grupo->grado ?? 'Grupo'); ?> - <?php echo e($grupo->grupo ?? $grupo->nombre ?? ''); ?>

                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-normal">
                                        <?php echo e($grupo->ciclo->nombre ?? $grupo->ciclo ?? 'N/A'); ?>

                                    </span>
                                </td>
                                <td class="text-secondary">
                                    <?php echo e($grupo->docenteTitular->name ?? $grupo->docenteTitular->nombre ?? 'Sin Asignar'); ?>

                                </td>
                                <td class="text-end pe-4">
                                    <a href="<?php echo e(route('grupos.index')); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No hay grupos registrados recientemente.</td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Alertas de Expedientes Incompletos (Columna Derecha 4/12) -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0 text-dark fs-6">Alertas de Expedientes</h5>
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2.5 py-1 fw-bold fs-7">
                        <?php echo e($expedientesIncompletosCount ?? 0); ?> Pendientes
                    </span>
                </div>

                <!-- Lista Dinámica de Alertas -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $expedientesIncompletos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumnoAlert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="alert-item-red">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                    <div class="w-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="alert-name"><?php echo e($alumnoAlert->nombre); ?> <?php echo e($alumnoAlert->apellido_p); ?></div>
                            <a href="<?php echo e(route('expedientes.show', $alumnoAlert->id_alumno)); ?>" class="text-danger small fw-bold">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="alert-desc">Expediente Incompleto (<?php echo e($alumnoAlert->documentos_count ?? 0); ?>/4 documentos)</div>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="text-center text-muted py-4">
                    <i class="bi bi-check-circle fs-2 text-success opacity-50 d-block mb-1"></i>
                    No hay expedientes pendientes.
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Natt\Documents\Proyecto Sis\sistema-escolar\resources\views/home.blade.php ENDPATH**/ ?>