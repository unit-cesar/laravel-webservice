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

Route::get('/', function () {
    return view('welcome');
});

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

Route::get('fooController/{id?}', ['uses' => 'tests\TestsController@foo']);

Route::post('fooControllerPost', ['uses' => 'tests\TestsController@fooPost']);

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