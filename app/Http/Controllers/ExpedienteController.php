<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\StudentDocument;
use App\Models\Calificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpedienteController extends Controller
{
    // Lista oficial y única de documentos requeridos
    public const DOCUMENTOS_REQUERIDOS = [
        'Acta de Nacimiento',
        'CURP',
        'Comprobante de Domicilio',
        'Certificado Médico'
    ];

    public function index(Request $request)
    {
        // Usamos solo 'grupo' para evitar problemas con 'grupo.grado' si no existe la relación
        $query = Alumno::with(['grupo', 'documentos']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('apellido_p', 'LIKE', "%{$buscar}%")
                  ->orWhere('apellido_m', 'LIKE', "%{$buscar}%")
                  ->orWhere('curp', 'LIKE', "%{$buscar}%")
                  ->orWhere('id_alumno', 'LIKE', "%{$buscar}%");
            });
        }

        $alumnos = $query->paginate(10);

        // Inyectamos el cálculo de completitud a cada alumno
        foreach ($alumnos as $alumno) {
            $docsSubidos = $alumno->documentos->pluck('tipo_documento')->toArray();
            $faltantes = array_diff(self::DOCUMENTOS_REQUERIDOS, $docsSubidos);
            $alumno->expediente_completo = count($faltantes) === 0;
            $alumno->total_pendientes = count($faltantes);
        }

        return view('expedientes.index', compact('alumnos'));
    }

    public function show($id)
    {
        // Cargamos el alumno con su grupo y sus documentos
        $alumno = Alumno::with(['grupo', 'documentos'])->findOrFail($id);

        $requeridos = self::DOCUMENTOS_REQUERIDOS;
        
        // Mapeamos los documentos subidos por tipo para identificarlos en la vista
        $documentosSubidos = $alumno->documentos->keyBy('tipo_documento');

        // Verificamos si subió todos los documentos requeridos
        $expedienteCompleto = $alumno->documentos->whereIn('tipo_documento', $requeridos)->count() >= count($requeridos);
        
        $calificaciones = []; // Aquí puedes incluir las calificaciones si tu modelo ya existe

        return view('expedientes.show', compact('alumno', 'requeridos', 'documentosSubidos', 'expedienteCompleto', 'calificaciones'));
    }

    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'tipo_documento' => 'required|string',
            'archivo'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Máx 5MB
        ]);

        $alumno = Alumno::findOrFail($id);

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $path = $file->store("expedientes/{$alumno->id_alumno}", 'public');

            StudentDocument::updateOrCreate(
                [
                    'id_alumno'      => $alumno->id_alumno,
                    'tipo_documento' => $request->tipo_documento,
                ],
                [
                    'ruta_archivo' => $path,
                    'extension'    => $file->getClientOriginalExtension(),
                    'fecha_carga'  => now(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Documento subido correctamente.');
    }

    public function downloadDocument($idDocumento)
    {
        $doc = StudentDocument::findOrFail($idDocumento);
        
        if (Storage::disk('public')->exists($doc->ruta_archivo)) {
            return Storage::disk('public')->download($doc->ruta_archivo);
        }

        return redirect()->back()->with('error', 'El archivo solicitado no existe en el servidor.');
    }
}