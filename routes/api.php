<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Para POST, PUT, DELETE pelo Blade, setar as rotas em 'routes/web.php
// ->middleware('auth')

// Para POST, PUT, DELETE pela API, setar as rotas em 'routes/api.php
// ->middleware('auth:api')

// Rotas em: 'routes/web.php' necessita de 'csrf-token'
// Rotas em: 'routes/api.php' desabilitam e função 'csrf-token' automaticamente.

Route::get('/test', function () {
    return 'ok';
})->middleware('auth:api');

// ROTAS PARA API
// Criar função para gerar todos grupos e controles de uma array
Route::name('api.admin.')->prefix('adm')->middleware('auth:api')->namespace('Admin')->group(function () {
    // Name is prefix in code - admin.xyz (route) >>> Criar diretório para manter o padrão em Views -> views/admin
    // Prefix is prefix in URL - adm/xyz
    // ->namespace('Admin') caso haja diretórios no Controller

    // URL: adm/
    Route::get('/', function () {
        return view('admin.index');
    });

    // URL em português e codigo interno em inglês
    Route::resource('courses', 'CourseController')->names([
        'index' => 'courses',
        'create' => 'courses.create',
        'store' => 'courses.store',
        'show' => 'courses.show',
        'edit' => 'courses.edit',
        'update' => 'courses.update',
        'destroy' => 'courses.destroy'
    ]);

    Route::resource('users', 'UserController')->names([
        'index' => 'users',
        'create' => 'users.create',
        'store' => 'users.store',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy'
    ]);

    Route::resource('roles', 'RoleController')->names([
        'index' => 'roles',
        'create' => 'roles.create',
        'store' => 'roles.store',
        'show' => 'roles.show',
        'edit' => 'roles.edit',
        'update' => 'roles.update',
        'destroy' => 'roles.destroy'
    ]);

    Route::resource('permissions', 'PermissionController')->names([
        'index' => 'permissions',
        'create' => 'permissions.create',
        'store' => 'permissions.store',
        'show' => 'permissions.show',
        'edit' => 'permissions.edit',
        'update' => 'permissions.update',
        'destroy' => 'permissions.destroy'
    ]);

});



Route::namespace('AuthApi')->group(function () {
    // Name is prefix in code - admin.xyz (route) >>> Criar diretório para manter o padrão em Views -> views/admin
    // Prefix is prefix in URL - adm/xyz
    // ->namespace('Admin') caso haja diretórios no Controller

    // Fazer metodos espelhados no Auth::routes(); de 'routes/web.php'
    // Ou em: vendor/laravel/framework/src/Illuminate/Routing/Router.php

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');

    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm');
    Route::post('register', 'RegisterController@register');

    // // Password Reset Routes...
    // Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    // Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    // Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    // Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    //
    // // Emails Routes
    // Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    // Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
    // Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');

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
 *
 *

    https://developer.mozilla.org/en-US/docs/Web/HTTP/Status

    index   200/204
    create  202/203
    store   201/204
    show    200/204
    edit    202/203
    update  200/204
    destroy 200/204

Respostas de sucesso
    200 OK
    201 Created
    202 Accepted
    203 Non-Authoritative Information
    204 No Content
    205 Reset Content
    206 Partial Content
    207 Multi-Status (WebDAV)
    208 Multi-Status (WebDAV)
    226 IM Used (HTTP Delta encoding)

Mensagens de redirecionamento
    300 Multiple Choice
    301 Moved Permanently
    302 Found
    303 See Other
    304 Not Modified
    305 Use Proxy
    306 unused
    307 Temporary Redirect
    308 Permanent Redirect

Respostas de erro do Cliente
    400 Bad Request
    401 Unauthorized
    402 Payment Required
    403 Forbidden
    404 Not Found
    405 Method Not Allowed
    406 Not Acceptable
    407 Proxy Authentication Required
    408 Request Timeout
    409 Conflict
    410 Gone
    411 Length Required
    412 Precondition Failed
    413 Payload Too Large
    414 URI Too Long
    415 Unsupported Media Type
    416 Requested Range Not Satisfiable
    417 Expectation Failed
    418 I'm a teapot
    421 Misdirected Request
    422 Unprocessable Entity (WebDAV)
    423 Locked (WebDAV)
    424 Failed Dependency (WebDAV)
    426 Upgrade Required
    428 Precondition Required
    429 Too Many Requests
    431 Request Header Fields Too Large
    451 Unavailable For Legal Reasons

Respostas de erro do Servidor
    500 Internal Server Error
    501 Not Implemented
    502 Bad Gateway
    503 Service Unavailable
    504 Gateway Timeout
    505 HTTP Version Not Supported
    506 Variant Also Negotiates
    507 Insufficient Storage
    508 Loop Detected (WebDAV)
    510 Not Extended
    511 Network Authentication Required

*/


// // api/user (GET) - Teste de rota protegida
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     // Com Postman enviar via GET (Headers)
//     // 'Accept' => 'application/json',
//     // 'Authorization' => 'Bearer '.$accessToken, // cuidado com espaço após Bearer!
//     return $request->user();
// });
//
// // api/test (GET)
// Route::get('/test', function (Request $request) {
//     // http://127.0.0.1:8000/api/test?name=devesa&email=devesa@gmail.com
//     return $request->all();
// });
//
// // api/test (POST) - Teste de cadastro e geração de token(login)
// Route::post('/test', function (Request $request) {
//     // Com Postman enviar via POST (Body) [name, email, password]
//
//     $user = \App\User::create([
//         'name' => $request['name'],
//         'email' => $request['email'],
//         // 'password' => Hash::make($request['password']),
//         'password' => $request['password'],
//     ]);
//
//     // Personal Access Tokens
//     // https://laravel.com/docs/5.7/passport#personal-access-tokens
//     $user->token = $user->createToken($user->email)->accessToken;
//
//     return response($user, 201);
//
// });
