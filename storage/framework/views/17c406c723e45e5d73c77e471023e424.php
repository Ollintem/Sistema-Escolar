<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4 px-4">
    <!-- Encabezado con Acciones -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill fw-bold">
                    <i class="bi bi-diagram-3-fill me-1"></i> Control Académico
                </span>
            </div>
            <h2 class="fw-bold text-dark mb-1">Gestión de Grupos</h2>
            <p class="text-muted mb-0">Administración de grupos, turnos, docentes titulares y materias asignadas.</p>
        </div>
        <div class="d-flex gap-2">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('grupos.crear')): ?>
            <button class="btn btn-outline-primary rounded-pill px-4 py-2.5 shadow-sm fw-bold d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNuevoGrado">
                <i class="bi bi-journal-plus fs-5"></i> Nuevo Grado
            </button>
            <button class="btn btn-primary rounded-pill px-4 py-2.5 shadow-sm fw-bold d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNuevoGrupo">
                <i class="bi bi-plus-lg fs-5"></i> Nuevo Grupo
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
                    <strong class="d-block">¡Operación Exitosa!</strong>
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
                    <strong class="d-block">Error al procesar la solicitud:</strong>
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
                        <i class="bi bi-collection-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-semibold d-block">Grupos Registrados</span>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo e(count($grupos ?? [])); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-info">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle p-3 me-3">
                        <i class="bi bi-person-badge-fill fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-semibold d-block">Docentes Disponibles</span>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo e(count($docentes ?? [])); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-success">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                        <i class="bi bi-check-all fs-3"></i>
                    </div>
                    <div>
                        <span class="text-muted fs-7 text-uppercase fw-semibold d-block">Ciclos Activos</span>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo e(count($ciclos ?? [])); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla Principal de Grupos -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 border-bottom">
            <h6 class="fw-bold mb-0 text-secondary"><i class="bi bi-list-nested me-2"></i>Catálogo de Grupos Activos</h6>
            <div class="position-relative" style="max-width: 300px;">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" id="busquedaGrupo" class="form-control ps-5 rounded-pill border-0 bg-light" placeholder="Buscar grupo, docente, ciclo...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0" id="tablaGrupos">
                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                        <tr>
                            <th class="py-3">GRUPO / TURNO</th>
                            <th class="py-3">CICLO ESCOLAR</th>
                            <th class="py-3">DOCENTE TITULAR</th>
                            <th class="py-3">MATERIAS Y DOCENTES ASIGNADOS</th>
                            <th class="text-end pe-4 py-3">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $grupos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold text-dark fs-6">
                                        <?php echo e($grupo->grado->nombre ?? $grupo->grado); ?> - <?php echo e($grupo->grupo ?? $grupo->nombre); ?>

                                    </span>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border rounded-pill px-2.5 py-1">
                                        <i class="bi bi-clock me-1"></i><?php echo e($grupo->turno); ?>

                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-1.5 rounded-pill font-monospace">
                                    <i class="bi bi-calendar3 me-1"></i><?php echo e($grupo->ciclo->nombre ?? 'Sin Asignar'); ?>

                                </span>
                            </td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($grupo->docenteTitular): ?>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-7" style="width: 32px; height: 32px;">
                                            <?php echo e(strtoupper(substr($grupo->docenteTitular->name ?? $grupo->docenteTitular->nombre, 0, 1))); ?>

                                        </div>
                                        <span class="fw-semibold text-dark"><?php echo e($grupo->docenteTitular->name ?? $grupo->docenteTitular->nombre); ?></span>
                                    </div>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border px-2.5 py-1 rounded-2"><i class="bi bi-dash-circle me-1"></i>Sin Asignar</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_2 = true; $__currentLoopData = $grupo->materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <?php
                                            $docenteMateriaId = $materia->pivot->docente_id ?? null;
                                            $docenteObj = $docentes->firstWhere('id', (int)$docenteMateriaId);
                                        ?>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-info bg-opacity-10 text-info-emphasis border border-info-subtle px-2 py-1 rounded-2 small fw-semibold">
                                                <i class="bi bi-journal-bookmark me-1"></i><?php echo e($materia->nombre); ?>

                                            </span>
                                            <small class="text-secondary fs-7">
                                                <i class="bi bi-person me-1"></i><?php echo e($docenteObj->name ?? $docenteObj->nombre ?? 'Sin docente'); ?>

                                            </small>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <span class="text-muted small italic">Sin materias asignadas</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group gap-1">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('grupos.editar')): ?>
                                    <a href="<?php echo e(route('grupos.edit', $grupo->id_grupo)); ?>" 
                                       class="btn btn-sm btn-light text-primary rounded-circle border shadow-sm" 
                                       title="Editar Grupo">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('grupos.eliminar')): ?>
                                    <form action="<?php echo e(route('grupos.destroy', $grupo->id_grupo)); ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este grupo?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle border shadow-sm" title="Eliminar Grupo">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-diagram-3 fs-1 text-secondary opacity-50 d-block mb-3"></i>
                                <h5>No hay grupos registrados en el sistema</h5>
                                <p class="small text-muted mb-0">Comienza registrando un grado y luego crea un nuevo grupo.</p>
                            </td>
                        </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Grado -->
<div class="modal fade" id="modalNuevoGrado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4 pb-0">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-journal-plus text-primary"></i> Registrar Nuevo Grado
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('grados.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">NOMBRE DEL GRADO *</label>
                        <input type="text" name="nombre" class="form-control form-control-lg rounded-3 fs-6" placeholder="Ej. 1°, Primer Semestre" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">Guardar Grado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nuevo Grupo -->
<div class="modal fade" id="modalNuevoGrupo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4 pb-0">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-diagram-3 text-primary"></i> Crear Nuevo Grupo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('grupos.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary small">GRADO *</label>
                            <select name="id_grado" class="form-select rounded-3" required>
                                <option value="">Seleccione Grado...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $grados ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($grado->id_grado); ?>"><?php echo e($grado->nombre); ?> (<?php echo e($grado->nivel ?? 'Semestre'); ?>)</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary small">GRUPO / IDENTIFICADOR *</label>
                            <input type="text" name="nombre" class="form-control rounded-3" placeholder="Ej. A, B, 101" required value="<?php echo e(old('nombre')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary small">TURNO *</label>
                            <select name="turno" class="form-select rounded-3" required>
                                <option value="Matutino">Matutino</option>
                                <option value="Vespertino">Vespertino</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">CICLO ESCOLAR *</label>
                            <select name="id_ciclo" class="form-select rounded-3" required>
                                <option value="">Seleccione ciclo...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ciclos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ciclo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($ciclo->id_ciclo); ?>"><?php echo e($ciclo->nombre); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">DOCENTE TITULAR</label>
                            <select name="docente_id" class="form-select rounded-3">
                                <option value="">Sin Asignar</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $docentes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($docente->id); ?>"><?php echo e($docente->name ?? $docente->nombre); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- ASIGNACIÓN DE MATERIAS Y DOCENTES POR MATERIA -->
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold text-secondary small">ASIGNACIÓN DE MATERIAS Y DOCENTES POR ASIGNATURA</label>
                            <div class="card border-0 bg-light p-3 rounded-3" style="max-height: 250px; overflow-y: auto;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $materias ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php $mId = $materia->id_materia ?? $materia->id; ?>
                                    <div class="row align-items-center mb-2 pb-2 border-bottom">
                                        <div class="col-md-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="materias[]" value="<?php echo e($mId); ?>" id="mat_<?php echo e($mId); ?>">
                                                <label class="form-check-label fw-semibold text-dark small" for="mat_<?php echo e($mId); ?>">
                                                    <?php echo e($materia->nombre); ?> <span class="text-muted font-monospace">(<?php echo e($materia->clave ?? 'S/C'); ?>)</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <select name="docentes_materia[<?php echo e($mId); ?>]" class="form-select form-select-sm rounded-3">
                                                <option value="">Seleccionar Docente Impartidor...</option>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $docentes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                    <option value="<?php echo e($docente->id); ?>"><?php echo e($docente->name ?? $docente->nombre); ?></option>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <div class="text-muted small ps-2">No hay materias registradas en el catálogo.</div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">Guardar Grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script de Búsqueda Dinámica -->
<script>
    document.getElementById('busquedaGrupo')?.addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        let filas = document.querySelectorAll('#tablaGrupos tbody tr');
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Natt\Documents\Proyecto Sis\sistema-escolar\resources\views/grupos/index.blade.php ENDPATH**/ ?>