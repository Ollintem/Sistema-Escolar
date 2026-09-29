<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Módulos del sistema
        $modulos = [
            'dashboard',
            'ciclos_escolares',
            'grupos',
            'alumnos',
            'materias',
            'boletas_reportes',
            'empleados',
            'roles_puestos'
        ];

        // Acciones disponibles
        $acciones = ['mostrar', 'crear', 'editar', 'eliminar', 'gestionar'];

        // Crear todos los permisos combinando módulo + acción
        foreach ($modulos as $modulo) {
            foreach ($acciones as $accion) {
                Permission::findOrCreate("{$modulo}.{$accion}");
            }
        }

        // Asignar todos los permisos al SuperAdmin
        $adminRole = Role::findOrCreate('Administrador');
        $adminRole->syncPermissions(Permission::all());
    }
}