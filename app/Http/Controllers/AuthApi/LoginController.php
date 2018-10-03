<?php

namespace App\Http\Controllers\AuthApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('login');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            // false -> User já autenticado!
            return response(['status' => 'false', 'message' => 'Usuário já está autenticado!'], 200);
        }

        // Não precisa retornar, pois já retorna code 401 pelo '->middleware('auth:api')'
        // return response(['status' => 'true'], 401);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if (!$validator->fails()) {
            if (Auth::attempt($credentials)) {
                // Authentication passed...
                $user = Auth()->user();
                $user->token = $user->createToken($user->email)->accessToken;
                return response($user, 200);
            } else {
                return response(['status' => 'false'], 403);
            }
        } else {
            return response($validator->messages(), 403);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            // Metodo criado no Model User.php, necessário para fazer logout com a API (deletar tokens)
            // php artisan make:model OauthAccessToken
            Auth::user()->deleteApiTokens()->delete();
        }
        return response('true', 200);
    }
}
