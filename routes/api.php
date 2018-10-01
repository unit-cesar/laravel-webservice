<?php

use Illuminate\Http\Request;
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

// api/user (GET) - Teste de rota protegida
Route::middleware('auth:api')->get('/user', function (Request $request) {
    // Com Postman enviar via GET (Headers)
    // 'Accept' => 'application/json',
    // 'Authorization' => 'Bearer '.$accessToken, // cuidado com espaço após Bearer!
    return $request->user();
});

// api/test (GET)
Route::get('/test', function (Request $request) {
    // http://127.0.0.1:8000/api/test?name=devesa&email=devesa@gmail.com
    return $request->all();
});

// api/test (POST) - Teste de cadastro e geração de token(login)
Route::post('/test', function (Request $request) {
    // Com Postman enviar via POST (Body) [name, email, password]

    $user = \App\User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        // 'password' => Hash::make($request['password']),
        'password' => $request['password'],
    ]);

    // Personal Access Tokens
    // https://laravel.com/docs/5.7/passport#personal-access-tokens
    $user->token = $user->createToken($user->email)->accessToken;

    return response($user, 201);

});

/*
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


/*

"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImYxZTVjZmJlZWEwY2YwYmYyZDNmNzEzNDhiMjI4MWU5YWEwNzc5Y2EzOGFiNDUyMzY0ZDE3Y2I5YjRmN2Y0YzQyY2ZmMDRhMDhmMmRhYmRhIn0.eyJhdWQiOiIxIiwianRpIjoiZjFlNWNmYmVlYTBjZjBiZjJkM2Y3MTM0OGIyMjgxZTlhYTA3NzljYTM4YWI0NTIzNjRkMTdjYjliNGY3ZjRjNDJjZmYwNGEwOGYyZGFiZGEiLCJpYXQiOjE1Mzg0MjkwMTEsIm5iZiI6MTUzODQyOTAxMSwiZXhwIjoxNTY5OTY1MDExLCJzdWIiOiIxOCIsInNjb3BlcyI6W119.JLSA4fKYxiiB22dptqqvDiYEWpooD1WaH5URPzrw-7Jl4yZqj0nDAcp8ntu7rGGbjl0gzoOtCusP1olF_DfyhkBv8bxTTI2DPRfj1MBdFm-D9yOEO-gpVN7dxSbefBErLAFgl3MZrlXyjgEjN_deM6rqQIqbdnPlkOqK2jZmRjLffb_mEE0rC5UbK8dE2ek5yqdnTg_SnMSx2FNLucjxbNP1LddTc7AActTiZrHuNGI9x14HeRUj8Ialcm3ucDDBUNHqDy8aQy8G44a2orpbauKC7-w4Hg8E2RuiLyG8x5Hz1tziV4rzawPgxKkNboemvyaRoDhy85vveOlyhypnBWP_vjo8Qcsh4HeVTMIAXMlVzvxi7bXr0X_QESmdttVxUTrsmcDLEmACMNPhW6KMYBNDIJlvBCLxsrisrl-ca5nTiFpQE-2DzONhoh1NLrHZATgF635hZ1AMQVCChvWYUCnvUhBC-cZebACnQO0qm4NghqrtC-w8AJ0gkQQQBB_C6rfXGm9irQQGDFQ3zqVleK6BNxYjeh47bRgVEReA0Ba12eXxnHaR8v1gTZEsEe74snMWySaeEirlBrUviKp0dmcAoUIxmF3DQcMRKly5eCfKwXUilZb8ohwJ4K1HDFX3Q-lgj1pK_FCrEeg5rW_3Quwf3rpFs59gS8jDda-EL_k"


 */
