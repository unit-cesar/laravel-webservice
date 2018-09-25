<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // firstOrCreate não duplica se existir
        $role1 = Permission::firstOrCreate([
            'name' => 'role-view',
            'description' => 'Listar Papeis'
        ]);

        $role2 = Permission::firstOrCreate([
            'name' => 'role-create',
            'description' => 'Criar Papeis'
        ]);

        $role3 = Permission::firstOrCreate([
            'name' => 'role-update',
            'description' => 'Atualizar Papeis'
        ]);

        $role4 = Permission::firstOrCreate([
            'name' => 'role-delete',
            'description' => 'Deletar Papeis'
        ]);

        $curso1 = Permission::firstOrCreate([
            'name' => 'curso-view',
            'description' => 'Listar Cursos'
        ]);

        $curso2 = Permission::firstOrCreate([
            'name' => 'curso-create',
            'description' => 'Criar Cursos'
        ]);

        $curso3 = Permission::firstOrCreate([
            'name' => 'curso-update',
            'description' => 'Atualizar Cursos'
        ]);

        $curso4 = Permission::firstOrCreate([
            'name' => 'curso-delete',
            'description' => 'Deletar Cursos'
        ]);

        echo 'New permissions created'.PHP_EOL;
    }
}
