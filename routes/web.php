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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [
    'as' => 'root',
    function () {
        return view('welcome');
    },
]);

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

// (pendente) Criar função para definir pra cada lang instalada
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

    // URL: adm/
    Route::get('/', function () {
        return view('admin.index');
    });

    // URL em português e codigo interno em inglês
    Route::resource('cursos', 'CourseController')->names([
        'index' => 'courses',
        'create' => 'courses.create',
        'store' => 'courses.store',
        'show' => 'courses.show',
        'edit' => 'courses.edit',
        'update' => 'courses.update',
        'destroy' => 'courses.destroy'
    ]);

    Route::resource('usuarios', 'UserController')->names([
        'index' => 'users',
        'create' => 'users.create',
        'store' => 'users.store',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy'
    ]);

    Route::resource('papeis', 'RoleController')->names([
        'index' => 'roles',
        'create' => 'roles.create',
        'store' => 'roles.store',
        'show' => 'roles.show',
        'edit' => 'roles.edit',
        'update' => 'roles.update',
        'destroy' => 'roles.destroy'
    ]);

    Route::resource('permissoes', 'PermissionController')->names([
        'index' => 'permissions',
        'create' => 'permissions.create',
        'store' => 'permissions.store',
        'show' => 'permissions.show',
        'edit' => 'permissions.edit',
        'update' => 'permissions.update',
        'destroy' => 'permissions.destroy'
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
