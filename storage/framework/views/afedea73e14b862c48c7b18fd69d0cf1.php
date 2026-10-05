<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4 px-4">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill fw-bold mb-2">
                <i class="bi bi-pencil-square me-1"></i> Control Académico
            </span>
            <h2 class="fw-bold text-dark mb-1">Editar Grupo: <?php echo e($grupo->grado); ?> - <?php echo e($grupo->grupo); ?></h2>
            <p class="text-muted mb-0">Actualiza la información del grupo, turno, ciclo y la asignación de materias con sus docentes impartidores.</p>
        </div>
        <a href="<?php echo e(route('grupos.index')); ?>" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-1"></i> Volver a la Lista
        </a>
    </div>

    <!-- Formulario de Edición -->
    <form action="<?php echo e(route('grupos.update', $grupo->id_grupo)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Datos Generales</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">GRADO *</label>
                        <select name="id_grado" class="form-select rounded-3" required>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $grados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($grado->id_grado); ?>" <?php echo e($grupo->id_grado == $grado->id_grado ? 'selected' : ''); ?>>
                                    <?php echo e($grado->nombre); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary small">GRUPO / NOMBRE *</label>
                        <input type="text" name="nombre" class="form-control rounded-3" value="<?php echo e(old('nombre', $grupo->grupo)); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">TURNO *</label>
                        <select name="turno" class="form-select rounded-3" required>
                            <option value="Matutino" <?php echo e($grupo->turno == 'Matutino' ? 'selected' : ''); ?>>Matutino</option>
                            <option value="Vespertino" <?php echo e($grupo->turno == 'Vespertino' ? 'selected' : ''); ?>>Vespertino</option>
                            <option value="Nocturno" <?php echo e($grupo->turno == 'Nocturno' ? 'selected' : ''); ?>>Nocturno</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">CICLO ESCOLAR *</label>
                        <select name="id_ciclo" class="form-select rounded-3" required>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ciclos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ciclo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($ciclo->id_ciclo); ?>" <?php echo e($grupo->id_ciclo == $ciclo->id_ciclo ? 'selected' : ''); ?>>
                                    <?php echo e($ciclo->nombre); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary small">DOCENTE TITULAR</label>
                        <select name="docente_id" class="form-select rounded-3">
                            <option value="">Sin Docente Titular</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $docentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($docente->id); ?>" <?php echo e($grupo->docente_id == $docente->id ? 'selected' : ''); ?>>
                                    <?php echo e($docente->name ?? $docente->nombre); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Asignación de Materias y Docentes -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-journal-check text-primary me-2"></i>Materias y Docentes Impartidores</h5>
                
                <?php
                    // Mapear materias asignadas con el ID del docente impartidor
                    $materiasAsignadas = $grupo->materias->keyBy('id_materia');
                ?>

                <div class="list-group list-group-flush border rounded-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $mId = $materia->id_materia ?? $materia->id;
                            $estaAsignada = $materiasAsignadas->has($mId);
                            $docenteAsignadoId = $estaAsignada ? $materiasAsignadas[$mId]->pivot->docente_id : null;
                        ?>
                        <div class="list-group-item p-3">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="materias[]" value="<?php echo e($mId); ?>" id="mat_<?php echo e($mId); ?>" <?php echo e($estaAsignada ? 'checked' : ''); ?>>
                                        <label class="form-check-label fw-semibold text-dark" for="mat_<?php echo e($mId); ?>">
                                            <?php echo e($materia->nombre); ?> <span class="text-muted font-monospace">(<?php echo e($materia->clave ?? 'S/C'); ?>)</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <select name="docentes_materia[<?php echo e($mId); ?>]" class="form-select form-select-sm rounded-3">
                                        <option value="">Seleccionar Docente Impartidor...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $docentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($docente->id); ?>" <?php echo e($docenteAsignadoId == $docente->id ? 'selected' : ''); ?>>
                                                <?php echo e($docente->name ?? $docente->nombre); ?>

                                            </option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
            <div class="card-footer bg-white p-4 text-end border-top">
                <a href="<?php echo e(route('grupos.index')); ?>" class="btn btn-light rounded-pill px-4 me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Natt\Documents\Proyecto Sis\sistema-escolar\resources\views/grupos/edit.blade.php ENDPATH**/ ?>