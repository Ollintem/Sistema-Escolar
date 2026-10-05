

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4 px-4">

    <!-- Navegación Superior / Breadcrumb -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Expediente del Alumno</h3>
        </div>
        <div>
            <a href="<?php echo e(route('expedientes.index')); ?>" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold border shadow-sm me-2">
                <i class="bi bi-arrow-left me-1"></i> Volver a Expedientes
            </a>
        </div>
    </div>
    
    <!-- Alerta de Expediente Incompleto -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$expedienteCompleto): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 p-3.5 bg-danger bg-opacity-10 text-danger d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 42px; height: 42px;">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                </div>
                <div>
                    <strong class="d-block text-dark fs-6 mb-0">Atención: Expediente Incompleto</strong>
                    <span class="small text-muted">Este expediente cuenta con documentos marcados como PENDIENTES.</span>
                </div>
            </div>
            <button class="btn btn-danger rounded-pill px-4 py-2 fw-bold shadow-sm flex-shrink-0" onclick="alert('Se ha enviado una notificación recordatorio al tutor.')">
                <i class="bi bi-bell-fill me-1"></i> Notificar Tutor
            </button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="row g-4">
        <!-- Columna Izquierda: Perfil del Alumno -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white h-100">
                <!-- Foto del Alumno -->
                <div class="position-relative d-inline-block mx-auto mb-3" style="width: 130px; height: 130px;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($alumno->foto) && Storage::disk('public')->exists($alumno->foto)): ?>
                        <img src="<?php echo e(asset('storage/' . $alumno->foto)); ?>" class="rounded-circle object-fit-cover w-100 h-100 shadow-sm border border-2 border-white" alt="Foto Alumno">
                    <?php else: ?>
                        <div class="w-100 h-100 rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold fs-1 border border-2 border-primary-subtle shadow-sm">
                            <?php echo e(strtoupper(substr($alumno->nombre, 0, 1))); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <h4 class="fw-bold text-dark mb-1"><?php echo e(ucwords(strtolower($alumno->nombre))); ?> <?php echo e(ucwords(strtolower($alumno->apellido_p))); ?> <?php echo e(ucwords(strtolower($alumno->apellido_m))); ?></h4>
                
                <!-- Badge de Grupo -->
                <div class="mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold fs-7 border border-primary-subtle">
                        <i class="bi bi-mortarboard-fill me-1"></i>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($alumno->grupo): ?>
                            <?php echo e($alumno->grupo->grado->nombre ?? $alumno->grupo->grado ?? 'Grupo'); ?> - <?php echo e($alumno->grupo->grupo ?? $alumno->grupo->clave ?? $alumno->grupo->id_grupo); ?>

                        <?php else: ?>
                            Sin Grupo Asignado
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </span>
                </div>

                <!-- Detalle de Información del Alumno -->
                <div class="text-start border-top pt-3 small">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="bi bi-calendar-event me-1"></i> Ciclo Escolar</span>
                        <span class="fw-bold text-dark"><?php echo e($alumno->grupo->cicloEscolar->nombre ?? '2026-2027'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="bi bi-droplet-fill me-1 text-danger"></i> Tipo de Sangre</span>
                        <span class="fw-bold text-dark"><?php echo e($alumno->tipo_sangre ?? 'O+'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="bi bi-person-vcard me-1"></i> CURP</span>
                        <span class="fw-bold text-dark font-monospace small"><?php echo e(strtoupper($alumno->curp ?? 'N/R')); ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="bi bi-person-heart me-1"></i> Tutor</span>
                        <span class="fw-bold text-dark"><?php echo e(ucwords(strtolower($alumno->tutor_nombre ?? $alumno->tutor ?? 'Sin Asignar'))); ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted"><i class="bi bi-telephone me-1"></i> Teléfono Tutor</span>
                        <span class="fw-bold text-dark font-monospace"><?php echo e($alumno->tutor_telefono ?? 'Sin Teléfono'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Pestañas de Documentación, Calificaciones, Asistencias -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                
                <!-- Navegación por Pestañas (Tabs) -->
                <ul class="nav nav-pills gap-2 border-bottom pb-3 mb-4" id="expedienteTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill px-4 fw-bold small" id="docs-tab" data-bs-toggle="tab" data-bs-target="#docs-pane" type="button" role="tab">
                            <i class="bi bi-folder-check me-1"></i> Documentos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4 fw-bold small" id="calif-tab" data-bs-toggle="tab" data-bs-target="#calif-pane" type="button" role="tab">
                            <i class="bi bi-journal-bookmark me-1"></i> Calificaciones
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4 fw-bold small" id="asistencia-tab" data-bs-toggle="tab" data-bs-target="#asistencia-pane" type="button" role="tab">
                            <i class="bi bi-calendar-check me-1"></i> Asistencias
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las Pestañas -->
                <div class="tab-content" id="expedienteTabsContent">
                    
                    <!-- Pestaña 1: Documentación -->
                    <div class="tab-pane fade show active" id="docs-pane" role="tabpanel" aria-labelledby="docs-tab">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="fw-bold text-dark mb-0">Documentación Requerida</h5>
                        </div>
                        
                        <div class="d-flex flex-column gap-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $requeridos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docNombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $docObj = $documentosSubidos->get($docNombre);
                                    $entregado = !is_null($docObj);
                                ?>
                                <div class="p-3 border rounded-4 d-flex align-items-center justify-content-between bg-light bg-opacity-50 hover-shadow transition">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0 <?php echo e($entregado ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-warning'); ?>" style="width: 44px; height: 44px;">
                                            <i class="bi <?php echo e($entregado ? 'bi-check-lg' : 'bi-exclamation-triangle-fill'); ?> fs-5"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark mb-0 fs-6"><?php echo e($docNombre); ?></strong>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($entregado): ?>
                                                <span class="small text-muted">
                                                    Tipo: <span class="fw-bold text-uppercase"><?php echo e($docObj->extension ?? 'PDF'); ?></span> | 
                                                    Cargado el: <?php echo e(\Carbon\Carbon::parse($docObj->fecha_carga ?? $docObj->created_at)->format('d/m/Y')); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="small text-muted">Estado: <span class="text-danger font-monospace">Pendiente de entrega</span></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($entregado): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
                                                <i class="bi bi-check-circle-fill me-1"></i> Entregado
                                            </span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('expedientes.download')): ?>
                                                <a href="<?php echo e(route('expedientes.download', $docObj->id)); ?>" class="btn btn-sm btn-white border shadow-sm rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Descargar Documento">
                                                    <i class="bi bi-download text-secondary"></i>
                                                </a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-3 py-2 rounded-pill fw-bold">
                                                Pendiente
                                            </span>
                                            <button class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalSubirDoc" onclick="prepararSubida('<?php echo e($docNombre); ?>')">
                                                <i class="bi bi-upload me-1"></i> Subir
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>

                    <!-- Pestaña 2: Calificaciones -->
                    <div class="tab-pane fade" id="calif-pane" role="tabpanel" aria-labelledby="calif-tab">
                        <h5 class="fw-bold text-dark mb-3">Historial de Calificaciones</h5>
                        <p class="text-muted small mb-4">Registro del rendimiento académico por materia en el ciclo escolar actual.</p>
                        
                        <div class="table-responsive">
                            <table class="table align-middle table-hover border rounded-3 overflow-hidden">
                                <thead class="bg-light small text-uppercase text-muted fw-bold">
                                    <tr>
                                        <th class="ps-3 py-3">Materia</th>
                                        <th class="text-center py-3">Parcial 1</th>
                                        <th class="text-center py-3">Parcial 2</th>
                                        <th class="text-center py-3">Parcial 3</th>
                                        <th class="text-center py-3">Promedio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-3 fw-bold text-dark">Matemáticas I</td>
                                        <td class="text-center">9.5</td>
                                        <td class="text-center">8.0</td>
                                        <td class="text-center">9.0</td>
                                        <td class="text-center"><span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-1 rounded-pill">8.8</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3 fw-bold text-dark">Español / Lengua Materna</td>
                                        <td class="text-center">10.0</td>
                                        <td class="text-center">9.5</td>
                                        <td class="text-center">9.0</td>
                                        <td class="text-center"><span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-1 rounded-pill">9.5</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pestaña 3: Asistencias -->
                    <div class="tab-pane fade" id="asistencia-pane" role="tabpanel" aria-labelledby="asistencia-tab">
                        <h5 class="fw-bold text-dark mb-3">Resumen de Asistencias</h5>
                        <p class="text-muted small mb-4">Métricas generales de asistencia del alumno durante el periodo lectivo.</p>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="p-3 border rounded-4 text-center bg-light">
                                    <span class="text-muted small d-block mb-1">Asistencias</span>
                                    <h3 class="fw-bold text-success mb-0">94%</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 border rounded-4 text-center bg-light">
                                    <span class="text-muted small d-block mb-1">Inasistencias</span>
                                    <h3 class="fw-bold text-danger mb-0">2</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 border rounded-4 text-center bg-light">
                                    <span class="text-muted small d-block mb-1">Retardos</span>
                                    <h3 class="fw-bold text-warning mb-0">1</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Subir Documento -->
<div class="modal fade" id="modalSubirDoc" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom py-3 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-cloud-arrow-up text-primary me-2"></i>Subir Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('expedientes.upload', $alumno->id_alumno)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <input type="hidden" name="tipo_documento" id="tipoDocInput">
                    <p class="text-muted small mb-3">Adjunta el archivo escaneado para <strong id="lblTipoDoc" class="text-dark"></strong>.</p>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small">SELECCIONAR ARCHIVO (PDF, JPG, PNG)</label>
                        <input type="file" name="archivo" class="form-control rounded-3" required accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="modal-footer border-top py-3 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-check-circle-fill me-1"></i> Cargar Archivo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function prepararSubida(tipo) {
        document.getElementById('tipoDocInput').value = tipo;
        document.getElementById('lblTipoDoc').textContent = tipo;
    }
</script>

<style>
    .fs-7 { font-size: 0.8rem; }
    .btn-white { background-color: #fff; }
    .btn-white:hover { background-color: #f8f9fa; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Natt\Documents\Proyecto Sis\sistema-escolar\resources\views/expedientes/show.blade.php ENDPATH**/ ?>