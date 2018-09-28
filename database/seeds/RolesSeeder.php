<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Força deletar pra recriar
        for ($i = 1; $i <= 5; $i++) {
            if (Role::find($i)) {

                Role::find($i)->delete();

            }
        }

        // updateOrCreate não duplica se existir
        Role::updateOrCreate(
            [
                'id' => '1',
            ],
            [
                'name' => 'SuperUser',
                'description' => 'Acesso total'
            ]
        );

        Role::updateOrCreate(
            [
                'id' => '2',
            ],
            [
                'name' => 'Registered',
                'description' => 'Ver publicados'
            ]
        );

        Role::updateOrCreate(
            [
                'id' => '3',
            ],
            [
                'name' => 'Author',
                'description' => 'Cria conteúdo'
            ]
        );


        Role::updateOrCreate(
            [
                'id' => '4',
            ],
            [
                'name' => 'Publisher',
                'description' => 'Deleta e edita os seus e dos outros e os publica'
            ]
        );

        Role::updateOrCreate(
            [
                'id' => '5',
            ],
            [
                'name' => 'Manager',
                'description' => 'Gerencia ACL (papeis e permissões)'
            ]
        );

        // Add Roles to users
        Role::find(2)->addPerm('1');
        Role::find(3)->addPerm('2');
        Role::find(3)->addPerm('3');
        Role::find(3)->addPerm('4');
        Role::find(4)->addPerm('1');
        Role::find(4)->addPerm('2');
        Role::find(4)->addPerm('3');
        Role::find(4)->addPerm('4');
        Role::find(4)->addPerm('13');
        Role::find(5)->addPerm('1');
        Role::find(5)->addPerm('2');
        Role::find(5)->addPerm('3');
        Role::find(5)->addPerm('4');
        Role::find(5)->addPerm('5');
        Role::find(5)->addPerm('6');
        Role::find(5)->addPerm('7');
        Role::find(5)->addPerm('8');
        Role::find(5)->addPerm('9');
        Role::find(5)->addPerm('13');
        Role::find(5)->addPerm('14');
        Role::find(5)->addPerm('15');
        Role::find(5)->addPerm('16');

        echo 'Roles updated or created successfully!' . PHP_EOL;
    }
}
