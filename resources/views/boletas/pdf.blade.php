<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta_Oficial_{{ $alumno->apellido_p }}_{{ $alumno->nombre }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 15px;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            color: #0d6efd;
            text-transform: uppercase;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 6px;
            vertical-align: middle;
        }
        .info-box {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 10px;
            border: 1px solid #e9ecef;
        }
        .label {
            font-weight: bold;
            color: #555;
            width: 90px;
        }
        .table-calificaciones {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table-calificaciones th {
            background-color: #0d6efd;
            color: white;
            padding: 8px;
            font-size: 10px;
            text-transform: uppercase;
        }
        .table-calificaciones td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .promedio-box {
            float: right;
            width: 200px;
            border: 2px solid #0d6efd;
            border-radius: 6px;
            text-align: center;
            padding: 8px;
            background-color: #f4f8ff;
        }
        .promedio-title {
            font-size: 10px;
            font-weight: bold;
            color: #0d6efd;
            text-transform: uppercase;
        }
        .promedio-val {
            font-size: 22px;
            font-weight: bold;
            color: #0d6efd;
        }
        .footer-signatures {
            margin-top: 60px;
            width: 100%;
        }
        .signature-line {
            border-top: 1px solid #aaa;
            width: 180px;
            margin: 0 auto;
            text-align: center;
            padding-top: 5px;
            font-size: 9px;
            color: #555;
        }
        /* Estilo para la foto más grande y cuadrada */
        .photo-img {
            width: 90px;
            height: 110px;
            border-radius: 6px;
            border: 2px solid #0d6efd;
            object-fit: cover;
        }
    </style>
</head>
<body>

    @php
        // Conversión de foto a Base64 para garantizar su renderizado directo en DomPDF
        $fotoPath = $alumno->foto ?? $alumno->foto_path ?? $alumno->avatar ?? null;
        $base64Foto = null;

        if ($fotoPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPath)) {
            $fullPath = storage_path('app/public/' . $fotoPath);
            $type = pathinfo($fullPath, PATHINFO_EXTENSION);
            $data = file_get_contents($fullPath);
            $base64Foto = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    @endphp

    <!-- Encabezado Oficial Único -->
    <table class="header">
        <tr>
            <td>
                <div class="title">Boleta Oficial de Calificaciones</div>
            </td>
            <td style="text-align: right;">
                <div style="font-size: 10px; color: #888;">Emisión: {{ date('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <!-- Información del Alumno -->
    <table class="info-table info-box">
        <tr>
            @if($base64Foto)
                <td style="width: 100px; text-align: center; padding-right: 10px;">
                    <img src="{{ $base64Foto }}" class="photo-img">
                </td>
            @endif
            <td>
                <table style="width: 100%;">
                    <tr>
                        <td class="label">Alumno:</td>
                        <td class="text-bold" style="font-size: 13px;">{{ $alumno->apellido_p }} {{ $alumno->apellido_m }} {{ $alumno->nombre }}</td>
                        <td class="label">Grado:</td>
                        <td class="text-bold">{{ $alumno->grupo->grado->nombre ?? $alumno->grupo->grado ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Grupo:</td>
                        <td>{{ $alumno->grupo->grupo ?? 'General' }}</td>
                        <td class="label">Ciclo Escolar:</td>
                        <td>2026 - 2027</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Tabla de Calificaciones por Parciales -->
    <table class="table-calificaciones">
        <thead>
            <tr>
                <th style="text-align: left;">Materia</th>
                <th style="text-align: center; width: 80px;">Parcial 1</th>
                <th style="text-align: center; width: 80px;">Parcial 2</th>
                <th style="text-align: center; width: 80px;">Parcial 3</th>
                <th style="text-align: center; width: 110px; background-color: #0b5ed7;">Promedio Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materias as $mat)
                @php
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
                @endphp
                <tr>
                    <td class="text-bold">{{ $mat->nombre }}</td>
                    <td class="text-center">{{ !is_null($p1) ? number_format($p1, 1) : '—' }}</td>
                    <td class="text-center">{{ !is_null($p2) ? number_format($p2, 1) : '—' }}</td>
                    <td class="text-center">{{ !is_null($p3) ? number_format($p3, 1) : '—' }}</td>
                    <td class="text-center text-bold" style="background-color: #f4f8ff; color: {{ !is_null($promFinal) ? ($promFinal >= 6.0 ? '#198754' : '#dc3545') : '#666' }};">
                        {{ !is_null($promFinal) ? number_format($promFinal, 1) : '—' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Resumen de Promedio General -->
    <div class="promedio-box">
        <div class="promedio-title">Promedio General</div>
        <div class="promedio-val">{{ number_format($promedioGeneral, 1) }}</div>
    </div>

    <div style="clear: both;"></div>

    <!-- Firmas Oficiales -->
    <table class="footer-signatures">
        <tr>
            <td style="width: 50%;">
                <div class="signature-line">
                    Firma y Sello de Control Escolar
                </div>
            </td>
            <td style="width: 50%;">
                <div class="signature-line">
                    Firma del Tutor(a)
                </div>
            </td>
        </tr>
    </table>

</body>
</html>