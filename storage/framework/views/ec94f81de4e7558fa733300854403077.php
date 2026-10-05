

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4 px-4">
    <!-- Header Principal -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill fw-bold">
                    <i class="bi bi-award-fill me-1"></i> Control Académico
                </span>
            </div>
            <h2 class="fw-bold text-dark mb-1">Captura de Calificaciones</h2>
            <p class="text-muted mb-0">Selecciona el grupo y la asignatura para capturar los parciales y calcular el promedio final automáticamente.</p>
        </div>
    </div>

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

    <!-- Selector de Grupo y Materia -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-4">
            <form method="GET" action="<?php echo e(route('calificaciones.index')); ?>" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-bold text-secondary small">SELECCIONAR GRUPO *</label>
                    <select name="id_grupo" id="selectGrupo" class="form-select rounded-3" required onchange="actualizarMaterias()">
                        <option value="">Seleccione un grupo...</option>
                        <?php
                            foreach($grupos as$g) {
                                $selected = request('id_grupo') ==$g->id_grupo ? 'selected' : '';
                                $nombreGrado = isset($g->grado->nombre) ? $g->grado->nombre :$g->grado;
                                $nombreGrupo = isset($g->grupo) ? $g->grupo :$g->nombre;
                                echo "<option value='{$g->id_grupo}' {$selected}>{$nombreGrado} - {$nombreGrupo} (Turno: {$g->turno})</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold text-secondary small">SELECCIONAR MATERIA *</label>
                    <select name="id_materia" id="selectMateria" class="form-select rounded-3" required>
                        <option value="">Seleccione materia...</option>
                        <?php
                            if ($grupoSeleccionado && isset($grupoSeleccionado->materias)) {
                                foreach ($grupoSeleccionado->materias as$m) {
                                    $mId = isset($m->id_materia) ? $m->id_materia :$m->id;
                                    $selectedM = request('id_materia') ==$mId ? 'selected' : '';
                                    $clave = isset($m->clave) ?$m->clave : 'S/C';
                                    echo "<option value='{$mId}' {$selectedM}>{$m->nombre} ({$clave})</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary rounded-pill w-100 fw-bold py-2 shadow-sm">
                        <i class="bi bi-search me-1"></i> Cargar Lista
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Matriz de Calificaciones -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($grupoSeleccionado &&$materiaSeleccionada): ?>
        <?php 
            $materiaIdActual = isset($materiaSeleccionada->id_materia) ? $materiaSeleccionada->id_materia :$materiaSeleccionada->id; 
            $nombreGradoSel = isset($grupoSeleccionado->grado->nombre) ? $grupoSeleccionado->grado->nombre :$grupoSeleccionado->grado;
            $nombreGrupoSel = isset($grupoSeleccionado->grupo) ? $grupoSeleccionado->grupo :$grupoSeleccionado->nombre;
        ?>
        <form action="<?php echo e(route('calificaciones.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id_grupo" value="<?php echo e($grupoSeleccionado->id_grupo); ?>">
            <input type="hidden" name="id_materia" value="<?php echo e($materiaIdActual); ?>">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-5">
                <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-journal-check text-primary me-2"></i>
                            Grupo: <span class="text-primary"><?php echo e($nombreGradoSel); ?> <?php echo e($nombreGrupoSel); ?></span> |
                            Materia: <span class="text-primary"><?php echo e($materiaSeleccionada->nombre); ?></span>
                        </h6>
                    </div>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-save-fill me-1"></i> Guardar Calificaciones
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr>
                                    <th class="ps-4 py-3">#</th>
                                    <th class="py-3">ALUMNO</th>
                                    <th class="py-3 text-center" style="width: 120px;">PARCIAL 1</th>
                                    <th class="py-3 text-center" style="width: 120px;">PARCIAL 2</th>
                                    <th class="py-3 text-center" style="width: 120px;">PARCIAL 3</th>
                                    <th class="py-3 text-center" style="width: 140px;">PROMEDIO</th>
                                    <th class="pe-4 py-3">OBSERVACIONES</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                <?php
                                    if (count($alumnos) > 0) {$counter = 1;
                                        foreach ($alumnos as $alumno) {$calif = $calificaciones->get($alumno->id_alumno);
                                            $p1 = isset($calif->parcial_1) ? $calif->parcial_1 : '';$p2 = isset($calif->parcial_2) ?$calif->parcial_2 : '';
                                            $p3 = isset($calif->parcial_3) ? $calif->parcial_3 : '';$prom = isset($calif->promedio_final) ?$calif->promedio_final : null;
                                            $obs = isset($calif->observaciones) ?$calif->observaciones : '';

                                            $badgeClass =$prom !== null 
                                                ? ($prom >= 6.0 ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle') 
                                                : 'bg-light text-muted border';
                                            $promText = $prom !== null ? number_format($prom, 1) : '-';

                                            echo "<tr>
                                                <td class='ps-4 fw-bold text-muted'>{$counter}</td>
                                                <td>
                                                    <div class='fw-bold text-dark'>{$alumno->nombre} {$alumno->apellido_p} {$alumno->apellido_m}</div>
                                                    <small class='text-muted font-monospace'>#{$alumno->id_alumno}</small>
                                                </td>
                                                <td>
                                                    <input type='number' step='0.1' min='0' max='10' name='calificaciones[{$alumno->id_alumno}][parcial_1]' class='form-control text-center rounded-3 fw-bold' value='{$p1}' placeholder='0.0'>
                                                </td>
                                                <td>
                                                    <input type='number' step='0.1' min='0' max='10' name='calificaciones[{$alumno->id_alumno}][parcial_2]' class='form-control text-center rounded-3 fw-bold' value='{$p2}' placeholder='0.0'>
                                                </td>
                                                <td>
                                                    <input type='number' step='0.1' min='0' max='10' name='calificaciones[{$alumno->id_alumno}][parcial_3]' class='form-control text-center rounded-3 fw-bold' value='{$p3}' placeholder='0.0'>
                                                </td>
                                                <td class='text-center'>
                                                    <span class='badge fs-6 rounded-pill px-3 py-2 {$badgeClass}'>{$promText}</span>
                                                </td>
                                                <td class='pe-4'>
                                                    <input type='text' name='calificaciones[{$alumno->id_alumno}][observaciones]' class='form-control form-control-sm rounded-3' value='{$obs}' placeholder='Opcional...'>
                                                </td>
                                            </tr>";
                                            $counter++;
                                        }
                                    } else {
                                        echo "<tr>
                                            <td colspan='7' class='text-center py-5 text-muted'>
                                                <i class='bi bi-people fs-2 d-block mb-2 opacity-50'></i>
                                                No hay alumnos inscritos en este grupo.
                                            </td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white p-4 text-end border-top">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                        <i class="bi bi-check-circle-fill me-1"></i> Guardar y Calcular Promedios
                    </button>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="card border-0 shadow-sm rounded-4 bg-white p-5 text-center text-muted">
            <i class="bi bi-mortarboard fs-1 text-primary opacity-50 mb-3"></i>
            <h5>Selecciona un Grupo y una Materia</h5>
            <p class="small mb-0">Usa el filtro superior para desplegar la matriz de captura de calificaciones.</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<script>
    const gruposData = <?php echo json_encode($grupos, 15, 512) ?>;

    function actualizarMaterias() {
        const grupoId = document.getElementById('selectGrupo').value;
        const selectMateria = document.getElementById('selectMateria');
        selectMateria.innerHTML = '<option value="">Seleccione materia...</option>';

        const grupoEncontrado = gruposData.find(g => g.id_grupo == grupoId);
        if (grupoEncontrado && grupoEncontrado.materias) {
            grupoEncontrado.materias.forEach(materia => {
                const opt = document.createElement('option');
                const materiaId = materia.id_materia || materia.id;
                opt.value = materiaId;
                opt.textContent = `${materia.nombre || materia.name} (${materia.clave ?? 'S/C'})`;
                selectMateria.appendChild(opt);
            });
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Natt\Documents\Proyecto Sis\sistema-escolar\resources\views/calificaciones/index.blade.php ENDPATH**/ ?>