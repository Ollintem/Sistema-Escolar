<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User; // o Alumno/Docente según el modelo que uses para la edición

class ProtectSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Obtenemos el ID desde los parámetros de la ruta
        $userId = $request->route('id') ?? $request->route('alumno') ?? $request->route('user');

        if ($userId) {
            // Buscamos el registro objetivo
            $targetUser = User::find($userId);

            // Condición de protección: por correo o por rol
            if ($targetUser && ($targetUser->email === 'admin@gmail.com' || $targetUser->role === 'superadmin')) {
                return redirect()->back()->with('error', 'El Administrador Principal del sistema no puede ser editado ni eliminado.');
            }
        }

        return $next($request);
    }
}