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

        $data = [
          'name' => 'Devesa',
          'email' => 'devesa@mail.com',
          'password' => bcrypt('123456'),
        ];

        if (User::where('email', '=', $data['email'])->count()) {
            $user = User::where('email', '=', $data['email'])->first();
            $user->update($data);
            echo 'User updated!'.PHP_EOL; // Saída no terminal; PHP_EOL = End of line / Fim de linha
        } else {
            User::create($data);
            echo 'New user create'.PHP_EOL;
        }
    }
}
