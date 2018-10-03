<?php

namespace App\Http\Controllers\AuthApi;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('register');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            // false -> User já autenticado!
            return response(['status' => 'false', 'message' => 'Usuário já está autenticado!'], 200);
        }

        // Não precisa retornar, pois já retorna code 401 pelo '->middleware('auth:api')'
        // return response(['status' => 'true'], 401);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!$validator->fails()) {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->addRole('2'); // Id 2 = Registered

            if (Auth::attempt($data)) {
                // Authentication passed...

                $user = Auth()->user();
                $user->token = $user->createToken($user->email)->accessToken;
                $user->roles;
                return response($user, 200);

            } else {
                return response(['status' => 'false','message' => 'Erro ao autenticar!'], 403);
            }

        } else {

            return response($validator->messages(), 203);

        }
    }

}
