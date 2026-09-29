<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PersonalController extends Controller
{
    public function empleados()
    {
        $roles = Role::withCount('users')->get();
        $empleados = User::with('roles')->get();

        return view('personal.empleados', compact('roles', 'empleados'));
    }

    // Guardar nuevo empleado
    public function storeEmpleado(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'role'         => 'required|exists:roles,name',
            'password'     => 'required|string|min:8',
            'telefono'     => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'telefono'     => $request->telefono,
            'especialidad' => $request->especialidad,
        ]);

        $user->assignRole($request->role);

        return back()->with('success', 'El usuario fue registrado exitosamente.');
    }

    // Actualizar empleado
    public function updateEmpleado(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'role'         => 'required|exists:roles,name',
            'password'     => 'nullable|string|min:8',
            'telefono'     => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:255',
        ]);

        $data = [
            'name'         => $request->name,
            'email'        => $request->email,
            'telefono'     => $request->telefono,
            'especialidad' => $request->especialidad,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        return back()->with('success', 'Empleado actualizado correctamente.');
    }

    // Eliminar empleado
    public function destroyEmpleado($id)
    {
        if (auth()->id() == $id) {
            return back()->with('error', 'No puedes eliminar tu propio usuario en sesión.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Empleado eliminado correctamente.');
    }

    // Vista Catálogo de Roles / Puestos
    public function roles()
    {
        $roles = Role::withCount('users')->get();
        return view('personal.roles', compact('roles'));
    }

    // Guardar nuevo puesto/rol
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        Role::create(['name' => $request->name]);

        return back()->with('success', 'Puesto creado con éxito.');
    }

    // Matriz de Permisos adaptada al Sistema Escolar
    public function permisos(Role $role)
    {
        // Módulos exactos de la barra lateral de tu sistema
        $modulos = [
            'dashboard'        => 'DASHBOARD',
            'ciclos_escolares' => 'CICLOS ESCOLARES',
            'grupos'           => 'GRUPOS',
            'alumnos'          => 'ALUMNOS',
            'materias'         => 'MATERIAS',
            'boletas_reportes' => 'BOLETAS & REPORTES',
            'empleados'        => 'EMPLEADOS',
            'roles_puestos'    => 'ROLES Y PUESTOS',
        ];

        $acciones = ['mostrar', 'crear', 'editar', 'eliminar', 'gestionar'];

        // Arreglo de nombres de permisos que el rol tiene asignados
        $rolePermisos = $role->permissions->pluck('name')->toArray();

        return view('personal.permisos', compact('role', 'modulos', 'acciones', 'rolePermisos'));
    }

    // Actualizar permisos asignados al rol
    public function updatePermisos(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions ?? []);
        return back()->with('success', 'Permisos actualizados correctamente.');
    }
}