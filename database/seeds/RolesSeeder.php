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
        // firstOrCreate não duplica se existir
        $data1 = Role::firstOrCreate([
            // Não pode ser apagado
            'name' => 'SuperUser',
            'description' => 'Acesso total'
        ]);

        $data2 = Role::firstOrCreate([
            'name' => 'PublicGuest',
            'description' => 'Ver publicados'
        ]);

        $data3 = Role::firstOrCreate([
            'name' => 'Author',
            'description' => 'Cria conteúdo'
        ]);


        $data4 = Role::firstOrCreate([
            'name' => 'Publisher',
            'description' => 'Deleta e edita os seus e dos outros e os publica'
        ]);

        $data5 = Role::firstOrCreate([
            'name' => 'Manager',
            'description' => 'Gerencia ACL (papeis e permissões)'
        ]);

        echo 'New roles created'.PHP_EOL;
    }
}
