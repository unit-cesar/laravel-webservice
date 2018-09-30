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
        // Força deletar pra recriar
        for ($i = 1; $i <= 16; $i++) {
            if (Permission::find($i)) {

                Permission::find($i)->delete();

            }
        }

        // updateOrCreate não duplica se existir
        Permission::updateOrCreate(
            [
                'id' => '1'
            ],
            [
                'name' => 'course-view',
                'description' => 'Listar Cursos'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '2'
            ],
            [
                'name' => 'course-create',
                'description' => 'Criar Cursos'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '3'
            ],
            [
                'name' => 'course-update',
                'description' => 'Atualizar Cursos'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '4'
            ],
            [
                'name' => 'course-delete',
                'description' => 'Deletar Cursos'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '5'
            ],
            [
                'name' => 'role-view',
                'description' => 'Listar Papeis'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '6'
            ],
            [
                'name' => 'role-create',
                'description' => 'Criar Papeis'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '7'
            ],
            [
                'name' => 'role-update',
                'description' => 'Atualizar Papeis'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '8'
            ],
            [
                'name' => 'role-delete',
                'description' => 'Deletar Papeis'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '9'
            ],
            [
                'name' => 'permission-view',
                'description' => 'Listar Permissão'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '10'
            ],
            [
                'name' => 'permission-create',
                'description' => 'Criar Permissão'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '11'
            ],
            [
                'name' => 'permission-update',
                'description' => 'Atualizar Permissão'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '12'
            ],
            [
                'name' => 'permission-delete',
                'description' => 'Deletar Permissão'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '13'
            ],
            [
                'name' => 'user-view',
                'description' => 'Listar Usuários'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '14'
            ],
            [
                'name' => 'user-create',
                'description' => 'Criar Usuários'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '15'
            ],
            [
                'name' => 'user-update',
                'description' => 'Atualizar Usuários'
            ]
        );

        Permission::updateOrCreate(
            [
                'id' => '16'
            ],
            [
                'name' => 'user-delete',
                'description' => 'Deletar Usuários'
            ]
        );


        echo 'Permissions updated or created successfully!' . PHP_EOL;
    }
}

