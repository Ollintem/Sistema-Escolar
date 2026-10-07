@extends('layouts.app')

@section('content')
<style>
    /* Estilos personalizados para los selectores de asistencia */
    .btn-check:checked + .btn-asistencia-p {
        background-color: #198754 !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(25, 135, 84, 0.3);
    }
    .btn-check:checked + .btn-asistencia-f {
        background-color: #dc3545 !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }
    .btn-check:checked + .btn-asistencia-r {
        background-color: #ffc107 !important;
        color: #212529 !important;
        box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);
    }
    .btn-check:checked + .btn-asistencia-j {
        background-color: #0dcaf0 !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(13, 202, 240, 0.3);
    }
    .btn-asistencia {
        border-radius: 8px !important;
        transition: all 0.2s ease-in-out;
        font-weight: 700;
        min-width: 42px;
    }
    .btn-asistencia:hover {
        transform: translateY(-2px);
    }
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
    }
</style>

<div class="container-fluid py-4 px-4">
    <!-- Header Principal -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Pase de Lista Diario</h2>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-3 py-3 px-4">
            <i class="bi bi-check-circle-fill fs-4 text-success"></i>
            <div class="fw-medium">{{ session('success') }}</div>
        </div>
    @endif

    <!-- Filtros Superior -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('asistencias.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase tracking-wide">
                        <i class="bi bi-diagram-3 me-1"></i> Grupo
                    </label>
                    <select name="id_grupo" class="form-select form-select-lg rounded-3 fs-6 border-light-subtle shadow-sm" onchange="this.form.submit()">
                        <option value="">-- Selecciona un Grupo --</option>
                        <?php if (isset($grupos) && count($grupos) > 0): ?>
                            <?php foreach ($grupos as$g): ?>
                                <?php $gId = $g->id_grupo ?? $g->id; ?>
                                <option value="<?php echo $gId; ?>" <?php echo ($grupoId ==$gId) ? 'selected' : ''; ?>>
                                    <?php echo ($g->grado->nombre ?? $g->grado ?? 'Grupo') . ' - ' . ($g->grupo ?? $g->clave); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase tracking-wide">
                        <i class="bi bi-journal-bookmark me-1"></i> Materia / Asignatura
                    </label>
                    <select name="id_materia" class="form-select form-select-lg rounded-3 fs-6 border-light-subtle shadow-sm" onchange="this.form.submit()">
                        <option value="">-- Asignatura General --</option>
                        <?php if (isset($materias) && count($materias) > 0): ?>
                            <?php foreach ($materias as$m): ?>
                                <?php $mId = $m->id_materia ?? $m->id; ?>
                                <option value="<?php echo $mId; ?>" <?php echo ($materiaId ==$mId) ? 'selected' : ''; ?>>
                                    <?php echo $m->nombre; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase tracking-wide">
                        <i class="bi bi-calendar3 me-1"></i> Fecha de Registro
                    </label>
                    <input type="date" name="fecha" class="form-control form-control-lg rounded-3 fs-6 border-light-subtle shadow-sm" value="{{ $fecha }}" onchange="this.form.submit()">
                </div>
            </form>
        </div>
    </div>

    <!-- Contenido cuando hay Grupo Seleccionado -->
    @if(!empty($grupoId))
        <?php 
            // Conteo rápido para los badges superiores
            $totalP = 0; $totalF = 0; $totalR = 0; $totalJ = 0;
            if (isset($alumnos) && count($alumnos) > 0) {
                foreach ($alumnos as $al) {$aId = $al->id_alumno ?? $al->id;
                    $st = 'P';
                    if (isset($asistenciasExistentes) && isset($asistenciasExistentes[$aId])) {$reg = $asistenciasExistentes[$aId];
                        $st = is_object($reg) ? $reg->estatus : ($reg['estatus'] ?? 'P');
                    }
                    if ($st == 'P')$totalP++;
                    elseif ($st == 'F')$totalF++;
                    elseif ($st == 'R')$totalR++;
                    elseif ($st == 'J')$totalJ++;
                }
            }
        ?>

        <!-- Métricas Rápidas -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-success bg-opacity-10 text-success p-3 d-flex flex-row align-items-center justify-content-between">
                    <div>
                        <div class="small fw-bold text-uppercase opacity-75">Presentes</div>
                        <div class="fs-3 fw-bold" id="cnt-p"><?php echo $totalP; ?></div>
                    </div>
                    <i class="bi bi-person-check fs-1 opacity-50"></i>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-danger bg-opacity-10 text-danger p-3 d-flex flex-row align-items-center justify-content-between">
                    <div>
                        <div class="small fw-bold text-uppercase opacity-75">Faltas</div>
                        <div class="fs-3 fw-bold" id="cnt-f"><?php echo $totalF; ?></div>
                    </div>
                    <i class="bi bi-person-x fs-1 opacity-50"></i>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-warning bg-opacity-10 text-dark p-3 d-flex flex-row align-items-center justify-content-between">
                    <div>
                        <div class="small fw-bold text-uppercase opacity-75">Retardos</div>
                        <div class="fs-3 fw-bold" id="cnt-r"><?php echo $totalR; ?></div>
                    </div>
                    <i class="bi bi-clock-history fs-1 opacity-50"></i>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 bg-info bg-opacity-10 text-info p-3 d-flex flex-row align-items-center justify-content-between">
                    <div>
                        <div class="small fw-bold text-uppercase opacity-75">Justificados</div>
                        <div class="fs-3 fw-bold" id="cnt-j"><?php echo $totalJ; ?></div>
                    </div>
                    <i class="bi bi-shield-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        <!-- Tabla con el Pase de Lista -->
        <form action="{{ route('asistencias.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_grupo" value="{{ $grupoId }}">
            <input type="hidden" name="id_materia" value="{{ $materiaId }}">
            <input type="hidden" name="fecha" value="{{ $fecha }}">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
                <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Nómina del Grupo</h5>
                        <small class="text-muted">Total de Alumnos: <?php echo count($alumnos); ?></small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 py-2 fw-bold" onclick="marcarTodos('P')">
                        <i class="bi bi-check2-all me-1"></i> Marcar Todos Presentes
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="bg-light text-secondary small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 py-3" style="width: 60px;">#</th>
                                <th class="py-3">ALUMNO</th>
                                <th class="text-center py-3" style="width: 320px;">ESTATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($alumnos) && count($alumnos) > 0): ?>
                                <?php foreach ($alumnos as $key =>$alumno): ?>
                                    <?php 
                                        $aId = $alumno->id_alumno ?? $alumno->id;
                                        $estatus = 'P';
                                        if (isset($asistenciasExistentes) && isset($asistenciasExistentes[$aId])) {$reg = $asistenciasExistentes[$aId];
                                            $estatus = is_object($reg) ? $reg->estatus : ($reg['estatus'] ?? 'P');
                                        }
                                        $iniciales = strtoupper(substr($alumno->nombre, 0, 1) . substr($alumno->apellido_p, 0, 1));
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted"><?php echo $key + 1; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-circle bg-primary bg-opacity-10 text-primary">
                                                    <?php echo $iniciales; ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0">
                                                        <?php echo $alumno->apellido_p . ' ' . $alumno->apellido_m . ' ' .$alumno->nombre; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group bg-light p-1 rounded-3 border" role="group">
                                                <!-- Presente (P) -->
                                                <input type="radio" class="btn-check radio-asistencia" name="asistencias[<?php echo $aId; ?>]" id="p_<?php echo $aId; ?>" value="P" <?php echo ($estatus == 'P') ? 'checked' : ''; ?> onchange="actualizarContadores()">
                                                <label class="btn btn-asistencia btn-asistencia-p btn-sm text-secondary" for="p_<?php echo $aId; ?>">P</label>

                                                <!-- Falta (F) -->
                                                <input type="radio" class="btn-check radio-asistencia" name="asistencias[<?php echo $aId; ?>]" id="f_<?php echo $aId; ?>" value="F" <?php echo ($estatus == 'F') ? 'checked' : ''; ?> onchange="actualizarContadores()">
                                                <label class="btn btn-asistencia btn-asistencia-f btn-sm text-secondary" for="f_<?php echo $aId; ?>">F</label>

                                                <!-- Retardo (R) -->
                                                <input type="radio" class="btn-check radio-asistencia" name="asistencias[<?php echo $aId; ?>]" id="r_<?php echo $aId; ?>" value="R" <?php echo ($estatus == 'R') ? 'checked' : ''; ?> onchange="actualizarContadores()">
                                                <label class="btn btn-asistencia btn-asistencia-r btn-sm text-secondary" for="r_<?php echo $aId; ?>">R</label>

                                                <!-- Justificado (J) -->
                                                <input type="radio" class="btn-check radio-asistencia" name="asistencias[<?php echo $aId; ?>]" id="j_<?php echo $aId; ?>" value="J" <?php echo ($estatus == 'J') ? 'checked' : ''; ?> onchange="actualizarContadores()">
                                                <label class="btn btn-asistencia btn-asistencia-j btn-sm text-secondary" for="j_<?php echo $aId; ?>">J</label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-5">
                                        <i class="bi bi-people fs-1 text-secondary opacity-50 d-block mb-2"></i>
                                        No hay alumnos registrados en este grupo.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (isset($alumnos) && count($alumnos) > 0): ?>
                    <div class="card-footer bg-white border-top p-3 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                            <i class="bi bi-save me-2"></i> Guardar Asistencias
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    @else
        <!-- Estado Vacío Inicial -->
        <div class="text-center py-5 bg-white rounded-4 shadow-sm my-4 p-5">
            <div class="bg-primary bg-opacity-10 text-primary d-inline-flex p-3 rounded-circle mb-3">
                <i class="bi bi-card-checklist fs-1"></i>
            </div>
            <h4 class="fw-bold text-dark">Pase de Lista Activo</h4>
            <p class="text-muted mb-0">Selecciona un grupo en los filtros superiores para comenzar a capturar la asistencia.</p>
        </div>
    @endif
</div>

<script>
    function marcarTodos(valor) {
        const radios = document.querySelectorAll(`.radio-asistencia[value="${valor}"]`);
        radios.forEach(radio => {
            radio.checked = true;
        });
        actualizarContadores();
    }

    function actualizarContadores() {
        let p = document.querySelectorAll('.radio-asistencia[value="P"]:checked').length;
        let f = document.querySelectorAll('.radio-asistencia[value="F"]:checked').length;
        let r = document.querySelectorAll('.radio-asistencia[value="R"]:checked').length;
        let j = document.querySelectorAll('.radio-asistencia[value="J"]:checked').length;

        if (document.getElementById('cnt-p')) document.getElementById('cnt-p').innerText = p;
        if (document.getElementById('cnt-f')) document.getElementById('cnt-f').innerText = f;
        if (document.getElementById('cnt-r')) document.getElementById('cnt-r').innerText = r;
        if (document.getElementById('cnt-j')) document.getElementById('cnt-j').innerText = j;
    }
</script>
@endsection