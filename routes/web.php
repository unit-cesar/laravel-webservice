<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['as'=>'home', function () {
    return view('welcome');
}]);

Route::get('fooHelloWorld/{id?}', function ($id = null) {
    return isset($id) ? "Olá mundo! - id: " . $id : "Olá mundo!";
});


/*
 * Pra funcionar POST, DELETE, PUT ou ANY no Postman a URI deve ser colocada em exceção em
 * app\Http\Middleware\VerifyCsrfToken.php
 * protected $except = [
 * 'fooPost'
 * ];
 *
 * OU no form inserir
 * @csrf
 *
 * */

Route::post('fooPost', function () {
//    var_dump($_POST);
//    dd($_POST);
    $res = isset($_POST['testPost']) ? "Olá POST! - testePost: " . $_POST['testPost'] : "Olá POST vazio!";
    $res .= isset($_POST['testPost2']) ? " - Olá POST! - testePost: " . $_POST['testPost2'] : " - Olá POST 2 vazio!";
    return $res;
});

Route::get('fooController/{id?}', ['uses' => 'TestController@foo']);

Route::post('fooControllerPost', ['uses' => 'TestController@fooPost']);

Route::get('testView', function () {
    $firstArray = [
      ['name' => 'Maria', 'email' => 'maria@mail.com'],
      ['name' => 'João', 'email' => 'joao@mail.com']
    ];

    $secondArray = [
      (object)['name' => 'Bakunin', 'email' => 'bakunin@mail.com'],
      (object)['name' => 'Proudhon', 'email' => 'proudhon@mail.com']
    ];
    return view('testView', compact('firstArray', 'secondArray'));
});

// Apelidos de rota, somente aqui fica em pt_BR

Route::get('contatos/{id}', ['as' => 'contacts.show', 'uses' => 'ContactController@show']);
Route::get('contatos', ['as' => 'contacts', 'uses' => 'ContactController@index']);


Route::get('adm/cursos', ['as' => 'admin.courses', 'uses' => 'CursoController@index']);
Route::get('adm/cursos/novo', ['as' => 'admin.courses.new', 'uses' => 'CursoController@create']);
Route::post('adm/cursos/grava', ['as' => 'admin.courses.store', 'uses' => 'CursoController@store']);
Route::get('adm/cursos/editar/{id}', ['as' => 'admin.courses.edit', 'uses' => 'CursoController@edit']);
Route::put('adm/cursos/atualizar/{id}', ['as' => 'admin.courses.update', 'uses' => 'CursoController@update']);
Route::get('adm/cursos/deletar/{id}', ['as' => 'admin.courses.delete', 'uses' => 'CursoController@destroy']);