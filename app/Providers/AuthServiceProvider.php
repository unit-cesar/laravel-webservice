<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
/*
 * ACL Map - Anarquico
 *
 * User 1 (Support)
 * - Tudo para testes e manutenção
 *
 * User 2 ()
 * -Ver tudo
 * -Cria
 * -Edita os seus
 * -Deleta os seus
 * -Publica os seus
 * -Sugere edição os de outros
 * -Sugere deletar os de outros
 * -Sugere publicar os de outros
 *
 * */

/*
 * ACL Map - Padrão
 *
 * SuperUsers
 * -Tudo
 *
 * PublicGuest
 * -ver publicados
 *
 * Registered
 * -ver os publicados
 *
 * Author
 * -ver os publicados
 * -cria
 *
 * Editor
 * -ver os publicados
 * -cria
 * -edita os seus
 * -edita os de outros
 * -publica os seus
 *
 * Publisher
 * -ver os publicados
 * -cria
 * -edita os seus
 * -edita os de outros
 * -publica os seus
 * -publica os de outros
 *
 * Manager
 * -ver os publicados
 * -cria
 * -edita os seus
 * -edita os de outros
 * -publica os seus
 * -publica os de outros
 * -deleta os seus
 * -deleta os de outros
 * -gerencia usuários(cria, deleta, edita)
 *
 * Administrator
  * -ver os publicados
 * -cria
 * -edita os seus
 * -edita os de outros
 * -publica os seus
 * -publica os de outros
 * -deleta os seus
 * -deleta os de outros
 * -gerencia usuários(cria, deleta, edita)
 * -gerencia ACL (papeis e permissões)
 * -gerencia Configurações do Sistema
 *
 * */



/*
 * ACL Map - Neste projeto
 *
 * SuperUsers
 * -Tudo
 *
 * PublicGuest
 * -ver publicados
 *
 * Registered
 * -ver os publicados
 *
 * Author
 * -ver os publicados
 * -cria
 *
 * Editor
 * -ver os publicados
 * -cria
 * -edita os seus
 * -edita os de outros
 * -publica os seus
 *
 * Publisher
 * -ver os publicados
 * -cria
 * -edita os seus
 * -edita os de outros
 * -publica os seus
 * -publica os de outros
 *
 * Manager
 * -ver os publicados
 * -cria
 * -edita os seus
 * -edita os de outros
 * -publica os seus
 * -publica os de outros
 * -deleta os seus
 * -deleta os de outros
 * //-gerencia usuários(cria, deleta, edita)
 *
 * */
