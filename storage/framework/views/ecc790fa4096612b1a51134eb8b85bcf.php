<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta_Oficial_<?php echo e($alumno->apellido_p); ?>_<?php echo e($alumno->nombre); ?></title>
    <style>
        @page {
            margin: 25px 30px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.4;
        }
        
        /* Header Principal */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .institution-name {
            font-size: 20px;
            font-weight: 800;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .document-type {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }
        .issue-date {
            font-size: 9px;
            color: #64748b;
            text-align: right;
            font-weight: 500;
        }

        /* Ficha del Alumno */
        .student-card {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 12px;
        }
        .photo-cell {
            width: 90px;
            vertical-align: middle;
            text-align: center;
            padding-right: 15px;
        }
        .photo-img {
            width: 85px;
            height: 105px;
            border-radius: 6px;
            border: 2px solid #cbd5e1;
            object-fit: cover;
        }
        .info-cell {
            vertical-align: middle;
        }
        .student-name {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 4px 0;
            font-size: 10px;
        }
        .label {
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 9px;
            width: 85px;
        }
        .value {
            color: #0f172a;
            font-weight: 700;
        }

        /* Tabla de Calificaciones */
        .table-grades {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-radius: 6px;
            overflow: hidden;
        }
        .table-grades th {
            background-color: #1e3a8a;
            color: #ffffff;
            padding: 10px 8px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            border: none;
        }
        .table-grades td {
            padding: 9px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
        }
        .table-grades tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .subject-name {
            font-weight: 700;
            color: #1e293b;
        }
        .grade-val {
            text-align: center;
            font-weight: 600;
            color: #334155;
        }
        .final-grade-cell {
            text-align: center;
            font-weight: 800;
            font-size: 11px;
            background-color: #eff6ff !important;
            border-left: 1px solid #dbeafe;
        }

        /* Resumen de Promedio */
        .summary-container {
            width: 100%;
            margin-bottom: 40px;
        }
        .promedio-card {
            float: right;
            width: 220px;
            background-color: #ffffff;
            border: 2px solid #1e3a8a;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }
        .promedio-label {
            font-size: 9px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .promedio-number {
            font-size: 24px;
            font-weight: 800;
            color: #1e3a8a;
            line-height: 1;
        }

        /* Firmas */
        .signatures-table {
            width: 100%;
            margin-top: 50px;
        }
        .signature-box {
            text-align: center;
            padding: 0 30px;
        }
        .signature-line-style {
            border-top: 1px solid #94a3b8;
            padding-top: 6px;
            font-size: 9px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
        }
        .signature-subtext {
            font-size: 8px;
            color: #94a3b8;
            font-weight: 500;
            margin-top: 2px;
        }
    </style>
</head>
<body>

    <?php
        // Procesamiento de foto a Base64 para DomPDF
        $fotoPath = $alumno->foto ?? $alumno->foto_path ?? $alumno->avatar ?? null;
        $base64Foto = null;

        if ($fotoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPath)) {
            $fullPath = storage_path('app/public/' . $fotoPath);
            $type = pathinfo($fullPath, PATHINFO_EXTENSION);
            $data = file_get_contents($fullPath);
            $base64Foto = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    ?>

    <!-- Encabezado Oficial -->
    <table class="header-table">
        <tr>
            <td>
                <div class="institution-name">Boleta Oficial de Calificaciones</div>
                <div class="document-type">Reporte Académico Institucional</div>
            </td>
            <td style="text-align: right; vertical-align: bottom;">
                <div class="issue-date">FECHA DE EMISIÓN: <strong><?php echo e(date('d/m/Y')); ?></strong></div>
            </td>
        </tr>
    </table>

    <!-- Ficha Informativa del Alumno -->
    <div class="student-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($base64Foto): ?>
                    <td class="photo-cell">
                        <img src="<?php echo e($base64Foto); ?>" class="photo-img">
                    </td>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <td class="info-cell">
                    <div class="student-name"><?php echo e($alumno->apellido_p); ?> <?php echo e($alumno->apellido_m); ?> <?php echo e($alumno->nombre); ?></div>
                    <table class="details-table">
                        <tr>
                            <td class="label">Grado:</td>
                            <td class="value"><?php echo e($alumno->grupo->grado->nombre ?? $alumno->grupo->grado ?? 'N/A'); ?></td>
                            <td class="label">Ciclo Escolar:</td>
                            <td class="value">2026 - 2027</td>
                        </tr>
                        <tr>
                            <td class="label">Grupo:</td>
                            <td class="value"><?php echo e($alumno->grupo->grupo ?? 'General'); ?></td>
                            <td class="label">Estatus:</td>
                            <td class="value" style="color: #16a34a;">ALUMNO REGULAR</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Tabla de Calificaciones -->
    <table class="table-grades">
        <thead>
            <tr>
                <th style="text-align: left; padding-left: 12px;">Asignatura / Materia</th>
                <th style="text-align: center; width: 75px;">Parcial 1</th>
                <th style="text-align: center; width: 75px;">Parcial 2</th>
                <th style="text-align: center; width: 75px;">Parcial 3</th>
                <th style="text-align: center; width: 105px; background-color: #1e40af;">Promedio Final</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
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
                <tr>
                    <td class="subject-name" style="padding-left: 12px;"><?php echo e($mat->nombre); ?></td>
                    <td class="grade-val"><?php echo e(!is_null($p1) ? number_format($p1, 1) : '—'); ?></td>
                    <td class="grade-val"><?php echo e(!is_null($p2) ? number_format($p2, 1) : '—'); ?></td>
                    <td class="grade-val"><?php echo e(!is_null($p3) ? number_format($p3, 1) : '—'); ?></td>
                    <td class="final-grade-cell" style="color: <?php echo e(!is_null($promFinal) ? ($promFinal >= 6.0 ? '#15803d' : '#b91c1c') : '#64748b'); ?>;">
                        <?php echo e(!is_null($promFinal) ? number_format($promFinal, 1) : '—'); ?>

                    </td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </tbody>
    </table>

    <!-- Contenedor del Promedio General -->
    <div class="summary-container">
        <div class="promedio-card">
            <div class="promedio-label">Promedio General de Aprovechamiento</div>
            <div class="promedio-number"><?php echo e(number_format($promedioGeneral, 1)); ?></div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <!-- Secciones de Firmas Oficiales -->
    <table class="signatures-table">
        <tr>
            <td style="width: 50%;">
                <div class="signature-box">
                    <div class="signature-line-style">Firma y Sello de Control Escolar</div>
                    <div class="signature-subtext">Dirección Académica</div>
                </div>
            </td>
            <td style="width: 50%;">
                <div class="signature-box">
                    <div class="signature-line-style">Firma del Tutor(a) / Padre de Familia</div>
                    <div class="signature-subtext">Conformidad de Calificaciones</div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html><?php /**PATH C:\Users\Natt\Documents\Proyecto Sis\sistema-escolar\resources\views/boletas/pdf.blade.php ENDPATH**/ ?>