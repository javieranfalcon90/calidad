<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::create(['name' => 'Index_Fuentes', 'group' => 'Fuentes']);
        Permission::create(['name' => 'Create_Fuentes', 'group' => 'Fuentes']);
        Permission::create(['name' => 'Update_Fuentes', 'group' => 'Fuentes']);
        Permission::create(['name' => 'Delete_Fuentes', 'group' => 'Fuentes']);

        Permission::create(['name' => 'Index_Requisitos', 'group' => 'Requisitos']);
        Permission::create(['name' => 'Create_Requisitos', 'group' => 'Requisitos']);
        Permission::create(['name' => 'Update_Requisitos', 'group' => 'Requisitos']);
        Permission::create(['name' => 'Delete_Requisitos', 'group' => 'Requisitos']);

        Permission::create(['name' => 'Index_Clasificaciones', 'group' => 'Clasificaciones']);
        Permission::create(['name' => 'Create_Clasificaciones', 'group' => 'Clasificaciones']);
        Permission::create(['name' => 'Update_Clasificaciones', 'group' => 'Clasificaciones']);
        Permission::create(['name' => 'Delete_Clasificaciones', 'group' => 'Clasificaciones']);

        Permission::create(['name' => 'Index_Procesos', 'group' => 'Procesos']);
        Permission::create(['name' => 'Create_Procesos', 'group' => 'Procesos']);
        Permission::create(['name' => 'Update_Procesos', 'group' => 'Procesos']);
        Permission::create(['name' => 'Delete_Procesos', 'group' => 'Procesos']);

        Permission::create(['name' => 'Index_Tipos', 'group' => 'Tipos']);
        Permission::create(['name' => 'Create_Tipos', 'group' => 'Tipos']);
        Permission::create(['name' => 'Update_Tipos', 'group' => 'Tipos']);
        Permission::create(['name' => 'Delete_Tipos', 'group' => 'Tipos']);

        Permission::create(['name' => 'Index_Responsables', 'group' => 'Responsables']);
        Permission::create(['name' => 'Create_Responsables', 'group' => 'Responsables']);
        Permission::create(['name' => 'Update_Responsables', 'group' => 'Responsables']);
        Permission::create(['name' => 'Delete_Responsables', 'group' => 'Responsables']);

        Permission::create(['name' => 'Index_Efectividades', 'group' => 'Efectividades']);
        Permission::create(['name' => 'Create_Efectividades', 'group' => 'Efectividades']);
        Permission::create(['name' => 'Update_Efectividades', 'group' => 'Efectividades']);
        Permission::create(['name' => 'Delete_Efectividades', 'group' => 'Efectividades']);

        Permission::create(['name' => 'Index_Niveles', 'group' => 'Niveles']);
        Permission::create(['name' => 'Create_Niveles', 'group' => 'Niveles']);
        Permission::create(['name' => 'Update_Niveles', 'group' => 'Niveles']);
        Permission::create(['name' => 'Delete_Niveles', 'group' => 'Niveles']);

        Permission::create(['name' => 'Index_Users', 'group' => 'Users']);
        Permission::create(['name' => 'Create_Users', 'group' => 'Users']);
        Permission::create(['name' => 'Update_Users', 'group' => 'Users']);
        Permission::create(['name' => 'Delete_Users', 'group' => 'Users']);

        Permission::create(['name' => 'Index_Roles', 'group' => 'Roles']);
        Permission::create(['name' => 'Create_Roles', 'group' => 'Roles']);
        Permission::create(['name' => 'Update_Roles', 'group' => 'Roles']);
        Permission::create(['name' => 'Delete_Roles', 'group' => 'Roles']);

        Permission::create(['name' => 'Index_Permissions', 'group' => 'Permissions']);
        Permission::create(['name' => 'Create_Permissions', 'group' => 'Permissions']);
        Permission::create(['name' => 'Update_Permissions', 'group' => 'Permissions']);
        Permission::create(['name' => 'Delete_Permissions', 'group' => 'Permissions']);

        Permission::create(['name' => 'Index_Audits', 'group' => 'Audits']);

        Permission::create(['name' => 'Index_Noconformidades', 'group' => 'Noconformidades']);
        Permission::create(['name' => 'Create_Noconformidades', 'group' => 'Noconformidades']);
        Permission::create(['name' => 'Update_Noconformidades', 'group' => 'Noconformidades']);
        Permission::create(['name' => 'Delete_Noconformidades', 'group' => 'Noconformidades']);
        Permission::create(['name' => 'Show_Any_Noconformidades', 'group' => 'Noconformidades']);
        Permission::create(['name' => 'Show_Own_Noconformidades', 'group' => 'Noconformidades']);
        Permission::create(['name' => 'Close_Noconformidades', 'group' => 'Noconformidades']);

        Permission::create(['name' => 'Index_Riesgos', 'group' => 'Riesgos']);
        Permission::create(['name' => 'Create_Riesgos', 'group' => 'Riesgos']);
        Permission::create(['name' => 'Update_Riesgos', 'group' => 'Riesgos']);
        Permission::create(['name' => 'Delete_Riesgos', 'group' => 'Riesgos']);
        Permission::create(['name' => 'Show_Any_Riesgos', 'group' => 'Riesgos']);
        Permission::create(['name' => 'Show_Own_Riesgos', 'group' => 'Riesgos']);
        Permission::create(['name' => 'Close_Riesgos', 'group' => 'Riesgos']);

        Permission::create(['name' => 'Index_Oportunidades', 'group' => 'Oportunidades']);
        Permission::create(['name' => 'Create_Oportunidades', 'group' => 'Oportunidades']);
        Permission::create(['name' => 'Update_Oportunidades', 'group' => 'Oportunidades']);
        Permission::create(['name' => 'Delete_Oportunidades', 'group' => 'Oportunidades']);
        Permission::create(['name' => 'Show_Any_Oportunidades', 'group' => 'Oportunidades']);
        Permission::create(['name' => 'Show_Own_Oportunidades', 'group' => 'Oportunidades']);
        Permission::create(['name' => 'Close_Oportunidades', 'group' => 'Oportunidades']);

        Permission::create(['name' => 'Create_Any_Analisis', 'group' => 'Análisis']);
        Permission::create(['name' => 'Create_Own_Analisis', 'group' => 'Análisis']);
        Permission::create(['name' => 'Update_Any_Analisis', 'group' => 'Análisis']);
        Permission::create(['name' => 'Update_Own_Analisis', 'group' => 'Análisis']);
        Permission::create(['name' => 'Delete_Any_Analisis', 'group' => 'Análisis']);
        Permission::create(['name' => 'Delete_Own_Analisis', 'group' => 'Análisis']);

        Permission::create(['name' => 'Create_Any_Acciones', 'group' => 'Acciones']);
        Permission::create(['name' => 'Create_Own_Acciones', 'group' => 'Acciones']);
        Permission::create(['name' => 'Update_Any_Acciones', 'group' => 'Acciones']);
        Permission::create(['name' => 'Update_Own_Acciones', 'group' => 'Acciones']);
        Permission::create(['name' => 'Delete_Any_Acciones', 'group' => 'Acciones']);
        Permission::create(['name' => 'Delete_Own_Acciones', 'group' => 'Acciones']);
        Permission::create(['name' => 'Show_Any_Acciones', 'group' => 'Acciones']);
        Permission::create(['name' => 'Show_Own_Acciones', 'group' => 'Acciones']);
        Permission::create(['name' => 'Close_Acciones', 'group' => 'Acciones']);

        Permission::create(['name' => 'Create_Any_Seguimientos', 'group' => 'Seguimientos']);
        Permission::create(['name' => 'Create_Own_Seguimientos', 'group' => 'Seguimientos']);
        Permission::create(['name' => 'Update_Any_Seguimientos', 'group' => 'Seguimientos']);
        Permission::create(['name' => 'Update_Own_Seguimientos', 'group' => 'Seguimientos']);
        Permission::create(['name' => 'Delete_Any_Seguimientos', 'group' => 'Seguimientos']);
        Permission::create(['name' => 'Delete_Own_Seguimientos', 'group' => 'Seguimientos']);

        Permission::create(['name' => 'Create_Any_Valoraciones', 'group' => 'Valoraciones']);
        Permission::create(['name' => 'Create_Own_Valoraciones', 'group' => 'Valoraciones']);
        Permission::create(['name' => 'Update_Any_Valoraciones', 'group' => 'Valoraciones']);
        Permission::create(['name' => 'Update_Own_Valoraciones', 'group' => 'Valoraciones']);
        Permission::create(['name' => 'Delete_Any_Valoraciones', 'group' => 'Valoraciones']);
        Permission::create(['name' => 'Delete_Own_Valoraciones', 'group' => 'Valoraciones']);

        $role = Role::create(['name' => 'ROLE_ADMIN']);

        $permissions = Permission::all();

        $role->syncPermissions($permissions);

        $user = User::create([
            'name' => 'Administrador',
            'email' => 'webmaster@cecmed.cu',
            'email_verified_at' => now(),
            'password' => Hash::make('Soloyoadministro+.'),
            'proceso_id' => null
        ]);

        $r = Role::first();
        $user->assignRole($r);


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
