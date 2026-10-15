@extends('layouts.app')

@section('content')
<style>
    .avatar-boleta {
        width: 75px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid #0d6efd;
    }
    .promedio-badge-lg {
        font-size: 1.35rem;
        font-weight: 800;
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        padding: 0.4rem 1.25rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
    }
</style>

<div class="container-fluid py-4 px-4">
    <!-- Header Principal -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Emisión de Boletas de Calificaciones</h2>
        </div>
    </div>

    <!-- Filtros de Selección -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-4">
            <form action="{{ route('boletas.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-bold small text-muted text-uppercase">
                        <i class="bi bi-diagram-3 me-1"></i> 1. Seleccionar Grupo
                    </label>
                    <select name="id_grupo" class="form-select form-select-lg rounded-3 fs-6 border-light-subtle shadow-sm" onchange="this.form.submit()">
                        <option value="">-- Selecciona un Grupo --</option>
                        <?php if (isset($grupos) && count($grupos) > 0): ?>
                            <?php foreach ($grupos as $g): ?>
                                <?php $gId = $g->id_grupo ?? $g->id; ?>
                                <option value="<?php echo $gId; ?>" <?php echo ($grupoId == $gId) ? 'selected' : ''; ?>>
                                    <?php echo ($g->grado->nombre ?? $g->grado ?? 'Grupo') . ' - ' . ($g->grupo ?? $g->clave); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label fw-bold small text-muted text-uppercase">
                        <i class="bi bi-person me-1"></i> 2. Seleccionar Alumno
                    </label>
                    <select name="id_alumno" class="form-select form-select-lg rounded-3 fs-6 border-light-subtle shadow-sm" onchange="this.form.submit()" <?php echo empty($grupoId) ? 'disabled' : ''; ?>>
                        <option value="">-- Selecciona un Alumno --</option>
                        <?php if (isset($alumnos) && count($alumnos) > 0): ?>
                            <?php foreach ($alumnos as $al): ?>
                                <?php $alId = $al->id_alumno ?? $al->id; ?>
                                <option value="<?php echo $alId; ?>" <?php echo ($alumnoId == $alId) ? 'selected' : ''; ?>>
                                    <?php echo $al->apellido_p . ' ' . $al->apellido_m . ' ' . $al->nombre; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('boletas.index') }}" class="btn btn-lg btn-outline-secondary w-100 rounded-3 fw-bold fs-6 shadow-sm">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Vista Previa de la Boleta -->
    <?php if ($alumnoSeleccionado): ?>
        <?php 
            $fotoPath = $alumnoSeleccionado->foto ?? $alumnoSeleccionado->foto_path ?? $alumnoSeleccionado->avatar ?? null; 
            $gradoNombre = $alumnoSeleccionado->grupo->grado->nombre ?? $alumnoSeleccionado->grupo->grado ?? 'N/A';
            $iniciales = strtoupper(substr($alumnoSeleccionado->nombre, 0, 1) . substr($alumnoSeleccionado->apellido_p, 0, 1));
        ?>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
            <!-- Header Alumno -->
            <div class="card-header bg-white py-4 px-4 d-flex align-items-center justify-content-between border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <?php if ($fotoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPath)): ?>
                        <img src="{{ asset('storage/' . $fotoPath) }}" alt="Foto Alumno" class="avatar-boleta shadow-sm">
                    <?php else: ?>
                        <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center fw-bold fs-2 shadow-sm" style="width: 75px; height: 90px;">
                            <?php echo $iniciales; ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-primary px-3 py-1 rounded-pill fw-bold">Grado: <?php echo $gradoNombre; ?></span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1 rounded-pill fw-bold">Grupo: <?php echo $alumnoSeleccionado->grupo->grupo ?? 'General'; ?></span>
                        </div>
                        <h3 class="fw-bold text-dark mb-1"><?php echo $alumnoSeleccionado->apellido_p . ' ' . $alumnoSeleccionado->apellido_m . ' ' . $alumnoSeleccionado->nombre; ?></h3>
                        <small class="text-muted"><i class="bi bi-check-circle-fill text-success me-1"></i>Alumno Activo Inscrito</small>
                    </div>
                </div>
                <div>
                    <a href="{{ route('boletas.pdf', ['alumnoId' => $alumnoSeleccionado->id_alumno ?? $alumnoSeleccionado->id]) }}" class="btn btn-danger btn-lg rounded-pill px-4 py-2.5 fw-bold shadow-sm d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-pdf-fill fs-5"></i> Descargar PDF
                    </a>
                </div>
            </div>

            <!-- Tabla de Calificaciones -->
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle table-hover border rounded-4 overflow-hidden">
                        <thead class="bg-light text-secondary small text-uppercase fw-bold text-center">
                            <tr>
                                <th class="text-start ps-4 py-3">ASIGNATURA / MATERIA</th>
                                <th class="py-3" style="width: 130px;">PARCIAL 1</th>
                                <th class="py-3" style="width: 130px;">PARCIAL 2</th>
                                <th class="py-3" style="width: 130px;">PARCIAL 3</th>
                                <th class="py-3 bg-primary bg-opacity-10 text-primary" style="width: 160px;">PROMEDIO FINAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($materias) && count($materias) > 0): ?>
                                <?php foreach ($materias as $mat): ?>
                                    <?php 
                                        $mId = $mat->id_materia ?? $mat->id;
                                        $registroCal = isset($calificaciones) && isset($calificaciones[$mId]) ? $calificaciones[$mId] : null;
                                        
                                        $p1 = $registroCal ? (is_object($registroCal) ? $registroCal->parcial_1 : ($registroCal['parcial_1'] ?? null)) : null;
                                        $p2 = $registroCal ? (is_object($registroCal) ? $registroCal->parcial_2 : ($registroCal['parcial_2'] ?? null)) : null;
                                        $p3 = $registroCal ? (is_object($registroCal) ? $registroCal->parcial_3 : ($registroCal['parcial_3'] ?? null)) : null;
                                        
                                        $promFinal = $registroCal ? (is_object($registroCal) ? $registroCal->promedio_final : ($registroCal['promedio_final'] ?? null)) : null;
                                        
                                        if (is_null($promFinal)) {
                                            $parciales = array_filter([$p1, $p2, $p3], function($v) { return !is_null($v); });
                                            $promFinal = count($parciales) > 0 ? array_sum($parciales) / count($parciales) : null;
                                        }
                                    ?>
                                    <tr class="text-center">
                                        <td class="text-start ps-4 fw-bold text-dark py-3">
                                            <i class="bi bi-journal-bookmark-fill text-primary opacity-50 me-2"></i>
                                            <?php echo $mat->nombre; ?>
                                        </td>
                                        <td class="fw-semibold text-secondary fs-6"><?php echo !is_null($p1) ? number_format($p1, 1) : '—'; ?></td>
                                        <td class="fw-semibold text-secondary fs-6"><?php echo !is_null($p2) ? number_format($p2, 1) : '—'; ?></td>
                                        <td class="fw-semibold text-secondary fs-6"><?php echo !is_null($p3) ? number_format($p3, 1) : '—'; ?></td>
                                        <td class="fw-bold fs-5 bg-primary bg-opacity-10 <?php echo !is_null($promFinal) ? ($promFinal >= 6.0 ? 'text-success' : 'text-danger') : 'text-muted'; ?>">
                                            <?php echo !is_null($promFinal) ? number_format($promFinal, 1) : '—'; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-journal-x fs-1 text-secondary opacity-50 d-block mb-2"></i>
                                        No hay materias asignadas a este grupo.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="bg-light fw-bold">
                            <tr>
                                <td colspan="4" class="ps-4 py-3 text-uppercase text-end fs-6 text-secondary">Promedio General de Aprovechamiento:</td>
                                <td class="text-center py-3">
                                    <span class="promedio-badge-lg d-inline-block">
                                        <?php echo number_format($promedioGeneral, 1); ?>
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Estado Vacío Inicial -->
        <div class="text-center py-5 bg-white rounded-4 shadow-sm my-4 p-5 border">
            <div class="bg-primary bg-opacity-10 text-primary d-inline-flex p-4 rounded-circle mb-3">
                <i class="bi bi-file-earmark-text-fill fs-1"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">Consulta de Boletas</h4>
            <p class="text-muted mb-0">Selecciona el **Grupo** y el **Alumno** en el panel superior para visualizar la boleta oficial.</p>
        </div>
    <?php endif; ?>
</div>
@endsection