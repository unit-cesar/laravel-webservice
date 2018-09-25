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


Route::get('/', [
    'as' => 'root',
    function () {
        return view('welcome');
    },
]);

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
        ['name' => 'João', 'email' => 'joao@mail.com'],
    ];

    $secondArray = [
        (object)['name' => 'Bakunin', 'email' => 'bakunin@mail.com'],
        (object)['name' => 'Proudhon', 'email' => 'proudhon@mail.com'],
    ];

    return view('testView', compact('firstArray', 'secondArray'));
});

// Apelidos de rota, somente aqui fica em pt_BR

Route::get('contatos/{id}', ['as' => 'contacts.show', 'uses' => 'ContactController@show']);
Route::get('contatos', ['as' => 'contacts', 'uses' => 'ContactController@index']);

Auth::routes();

// Criar função para definir pra cada lang instalada
Route::resourceVerbs([
    // Verbos da URL - foo/criar

    // pt-br
    'create' => 'criar',
    'edit' => 'editar',
]);

// Criar função para gerar todos grupos e controles de uma array
Route::name('admin.')->prefix('adm')->middleware('auth')->namespace('Admin')->group(function () {
    // Name is prefix in code - admin.xyz (route) >>> Criar diretório para manter o padrão em Views -> views/admin
    // Prefix is prefix in URL - adm/xyz
    // ->namespace('Admin') caso haja diretórios no Controller

    // Folder views/courses.blade.php (in controller)
    Route::resource('cursos', 'CursoController')->names([
        'index' => 'courses',
        'create' => 'courses.create',
        'store' => 'courses.store',
        'show' => 'courses.show',
        'edit' => 'courses.edit',
        'update' => 'courses.update',
        'destroy' => 'courses.destroy'
    ]);



});

/*
Route::resource('photos', 'PhotoController');
// ou
Route::resources([
    'photos' => 'PhotoController',
    'posts' => 'PostController'
]);

GET				/photos						index		photos.index
GET				/photos/create				create	    photos.create
POST			/photos						store		photos.store
GET				/photos/{photo}				show		photos.show
GET				/photos/{photo}/edit	    edit		photos.edit
PUT/PATCH	    /photos/{photo}				update	    photos.update
DELETE	    	/photos/{photo}				destroy	    photos.destroy
*/




Route::get('/home', 'HomeController@index')->name('home');

// Proteger grupo de rotas com prefixo
// Route::group(['prefix' => 'adm', 'middleware' => 'auth'], function () {
Route::prefix('adm')->middleware('auth')->group(function () {
    // Rotas protegidas
    // Route::get('cursos/novo', ['as' => 'admin.courses.new', 'uses' => 'CursoController@create']);
});

// Proteger grupo de rotas sem prefixo
Route::middleware(['auth'])->group(function () {
    // Route::get('adm/cursos/novo', ['as' => 'admin.courses.new', 'uses' => 'CursoController@create']);
});

// Route::get('adm/cursos/novo', ['as' => 'admin.courses.new', 'uses' => 'CursoController@create'])->middleware('auth');
