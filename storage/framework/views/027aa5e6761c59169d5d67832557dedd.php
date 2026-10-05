

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4 px-4">
    <!-- Encabezado Principal -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill fw-bold">
                    <i class="bi bi-calendar-range-fill me-1"></i> Calendario Escolar
                </span>
            </div>
            <h2 class="fw-bold text-dark mb-1">Gestión de Ciclos Escolares</h2>
            <p class="text-muted mb-0">Administración de periodos lectivos, aperturas y cierres de ciclos académicos.</p>
        </div>
        <div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ciclos.crear')): ?>
            <button class="btn btn-primary rounded-pill px-4 py-2.5 shadow-sm fw-bold d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNuevoCiclo">
                <i class="bi bi-plus-circle-fill fs-5"></i> Aperturar Ciclo
            </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mensajes de Alerta -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                <div>
                    <strong class="d-block">¡Operación realizada!</strong>
                    <span class="small"><?php echo e(session('success')); ?></span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                <div>
                    <strong class="d-block">Ocurrieron errores de validación:</strong>
                    <ul class="mb-0 ps-3 small">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <li><?php echo e($error); ?></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Tarjetas de Métricas Rápidas (KPIs) -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-primary">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                        <i class="bi bi-calendar3 fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-semibold d-block">Total de Ciclos</span>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo e(count($ciclos ?? [])); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-success">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                        <i class="bi bi-check-circle-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-semibold d-block">Ciclos Activos</span>
                        <h3 class="fw-bold mb-0 text-dark">
                            <?php echo e($ciclos ? $ciclos->where('estado', 'Activo')->count() : 0); ?>

                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-secondary">
                <div class="d-flex align-items-center">
                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle p-3 me-3">
                        <i class="bi bi-lock-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-semibold d-block">Ciclos Cerrados</span>
                        <h3 class="fw-bold mb-0 text-dark">
                            <?php echo e($ciclos ? $ciclos->where('estado', '!=', 'Activo')->count() : 0); ?>

                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla Principal -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 border-bottom">
            <h6 class="fw-bold mb-0 text-secondary"><i class="bi bi-list-ul me-2"></i>Listado de Periodos Escolares</h6>
            <div class="position-relative" style="max-width: 300px;">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" id="busquedaCiclo" class="form-control ps-5 rounded-pill border-0 bg-light" placeholder="Buscar por nombre o año...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="tablaCiclos">
                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                        <tr>
                            <th class="ps-4 py-3">ID</th>
                            <th class="py-3">NOMBRE DEL CICLO</th>
                            <th class="py-3">FECHA INICIO</th>
                            <th class="py-3">FECHA FIN</th>
                            <th class="py-3">ESTADO</th>
                            <th class="text-end pe-4 py-3">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $ciclos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ciclo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="ps-4">
                                <span class="font-monospace text-muted fw-bold">#<?php echo e($ciclo->id_ciclo); ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-7" style="width: 34px; height: 34px;">
                                        <i class="bi bi-calendar-event"></i>
                                    </div>
                                    <span class="fw-bold text-dark fs-6"><?php echo e($ciclo->nombre); ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="text-dark fw-medium">
                                    <i class="bi bi-calendar-plus text-primary me-1"></i>
                                    <?php echo e(\Carbon\Carbon::parse($ciclo->fecha_inicio)->format('d/m/Y')); ?>

                                </span>
                            </td>
                            <td>
                                <span class="text-dark fw-medium">
                                    <i class="bi bi-calendar-minus text-secondary me-1"></i>
                                    <?php echo e(\Carbon\Carbon::parse($ciclo->fecha_fin)->format('d/m/Y')); ?>

                                </span>
                            </td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ciclo->estado === 'Activo'): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill fw-bold">
                                        <i class="bi bi-dot"></i> Activo
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-1.5 rounded-pill fw-bold">
                                        <i class="bi bi-lock-fill me-1"></i> Cerrado
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <form action="<?php echo e(route('ciclos.toggle', $ciclo->id_ciclo)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ciclo->estado === 'Activo'): ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold shadow-sm" onclick="return confirm('¿Deseas cerrar este ciclo escolar?')">
                                            <i class="bi bi-lock me-1"></i> Cerrar Ciclo
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold shadow-sm">
                                            <i class="bi bi-unlock me-1"></i> Aperturar Ciclo
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </form>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-calendar-x fs-1 text-secondary opacity-50 d-block mb-3"></i>
                                <h5>No hay ciclos escolares registrados</h5>
                                <p class="small text-muted mb-0">Usa el botón "Aperturar Ciclo" para registrar un periodo académico.</p>
                            </td>
                        </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Aperturar Ciclo Escolar -->
<div class="modal fade" id="modalNuevoCiclo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4 pb-0">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-plus text-primary"></i> Aperturar Ciclo Escolar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('ciclos.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">NOMBRE DEL CICLO *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-card-heading"></i></span>
                            <input type="text" name="nombre" class="form-control rounded-end-3 border-start-0" placeholder="Ej. 2026 - 2027" required value="<?php echo e(old('nombre')); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">FECHA DE INICIO *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" name="fecha_inicio" class="form-control rounded-end-3 border-start-0" required value="<?php echo e(old('fecha_inicio')); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">FECHA DE TÉRMINO *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-check"></i></span>
                            <input type="date" name="fecha_fin" class="form-control rounded-end-3 border-start-0" required value="<?php echo e(old('fecha_fin')); ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">
                        <i class="bi bi-check-lg me-1"></i> Guardar Ciclo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script de Búsqueda Rápida -->
<script>
    document.getElementById('busquedaCiclo')?.addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        let filas = document.querySelectorAll('#tablaCiclos tbody tr');
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Natt\Documents\Proyecto Sis\sistema-escolar\resources\views/ciclos/index.blade.php ENDPATH**/ ?>