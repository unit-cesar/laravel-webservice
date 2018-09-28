<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Para correr essa seed:
        // php artisan db:seed --class UsersTableSeeder
        // ou todas as seeds
        // php artisan db:seed

        // Força deletar pra recriar
        for ($i = 1; $i <= 6; $i++) {
            if (User::find($i)) {

                User::find($i)->delete();

            }
        }


        User::updateOrCreate(
            [
                'id' => '1', // Definido para o SuperUser
                'email' => 'devesa@mail.com',
            ],
            [
                'name' => 'Devesa',
                'password' => bcrypt('123456'),
            ]
        );

        User::updateOrCreate(
            [
                'id' => '2',
                'email' => 'cesar@mail.com',
            ],
            [
                'name' => 'Cesar',
                'password' => bcrypt('123456'),
            ]
        );

        User::updateOrCreate(
            [
                'id' => '3',
                'email' => 'emma@mail.com',
            ],
            [
                'name' => 'Emma',
                'password' => bcrypt('123456'),
            ]
        );

        User::updateOrCreate(
            [
                'id' => '4',
                'email' => 'zezinho@mail.com',
            ],
            [
                'name' => 'Zezinho',
                'password' => bcrypt('123456'),
            ]
        );

        User::updateOrCreate(
            [
                'id' => '5',
                'email' => 'tita@mail.com',
            ],
            [
                'name' => 'Tita',
                'password' => bcrypt('123456'),
            ]
        );

        User::updateOrCreate(
            [
                'id' => '6',
                'email' => 'luacheia@mail.com',
            ],
            [
                'name' => 'Luacheia',
                'password' => bcrypt('123456'),
            ]
        );

        // Add Roles to users
        User::find(1)->addRole('1');
        User::find(2)->addRole('2');
        User::find(3)->addRole('3');
        User::find(4)->addRole('1');
        User::find(5)->addRole('4');
        User::find(6)->addRole('5');

        echo 'User updated or created successfully!' . PHP_EOL; // Saída no terminal; PHP_EOL = End of line / Fim de linha

    }
}
