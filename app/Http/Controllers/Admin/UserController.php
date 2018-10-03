<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Http\Response
     */
    public function index()
    {
        // ACL
        if (Gate::denies('user-view')) {
            return $this->apiOrBlade(); // API ou Blade
        }

        // API ou Blade
        if ($this->isAPI()) {
            $user = User::all();
            // (pendente) Enviar papeis de cada user ??????????????
            return response($user, 200);
        } else {
            $goToSection = 'index';
            $items = User::paginate(50); // limit de 50; Em blade: {{ $items->links() }}
            return view('admin.users', compact('items', 'goToSection'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     */
    public function create()
    {
        // ACL
        if (Gate::denies('user-create')) {
            return $this->apiOrBlade();
        }

        // API ou Blade
        if ($this->isAPI()) {
            return response('true', 202); // Libera abertura da view para o cliente
        } else {
            $goToSection = 'create';
            return view('admin.users', compact('goToSection'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|void
     */
    public function store(Request $request)
    {
        // ACL
        if (Gate::denies('user-create')) {
            return $this->apiOrBlade();
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // dd($data);
        // dd($validator->fails());
        // dd($validator->errors());

        if (!$validator->fails()) {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->addRole('2'); // Id 2 = Registered

            // API ou Blade
            if ($this->isAPI()) {
                $user->roles;
                // Personal Access Tokens - https://laravel.com/docs/5.7/passport#personal-access-tokens
                // Não é preciso enviar para outro user
                // $user->token = $user->createToken($user->email)->accessToken;
                return response($user, 201);
            } else {
                return redirect()->route('admin.users');
            }

        } else {
            return $this->validatorFail($validator);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        // ACL
        if (Gate::denies('user-view')) {
            return $this->apiOrBlade();
        }

        // Se a rota tiver nome diferente do Controller
        if (!isset($user->id)) {
            $user = User::find($id);
        }

        // API ou Blade
        if ($this->isAPI()) {
           $user->roles;
            return response($user, 200);
        } else {
            $goToSection = 'show';
            $record = $user;
            return view('admin.users', compact('goToSection', 'record'));
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, $id)
    {
        // ACL
        if (Gate::denies('user-update')) {
            return $this->apiOrBlade();
        }

        if (!isset($user->id)) {
            $user = User::find($id);
        }

        $recordRoles = Role::get();

        // API ou Blade
        if ($this->isAPI()) {
            $user->roles;
            return response(['user' => $user, 'recordRoles' => $recordRoles], 202);
        } else {
            $goToSection = 'edit';
            $record = $user;
            return view('admin.users', compact('goToSection', 'record', 'recordRoles'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, $id)
    {
        // ACL
        if (Gate::denies('user-update')) {
            return $this->apiOrBlade();
        }

        $data = $request->all();

        if (!isset($user->id)) {
            $user = User::find($id);
        }

        if (isset($data['role'])) {
            $user->addRole($data['role']);
            // API ou Blade
            if ($this->isAPI()) {
                $user->roles;
                return response($user, 200);
            } else {
                return redirect()->back();
            }
        }

        if (isset($data['removeRole'])) {

            // Verifica se não é role 'SuperAdmin' do user com 'id==1'
            if (($data['removeRole'] == 1) && ($user->id == 1)) {
                return $this->apiOrBlade('Este papel não pode ser removido para este usuário!');
            }

            $user->removeRole($data['removeRole']);

            // API ou Blade
            if ($this->isAPI()) {
                return response($user, 200);
            } else {
                return redirect()->back();
            }
        }

        $user->update($data);

        // API ou Blade
        if ($this->isAPI()) {
            return response($user, 200);
        } else {
            return redirect()->route('admin.users');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @param $id
     * @return \Illuminate\Http\Response|void
     * @throws \Exception
     */
    public function destroy(User $user, $id)
    {
        // ACL
        if (Gate::denies('user-delete')) {
            return $this->apiOrBlade();
        }

        if($this->protectedUsers($id)){
            return $this->protectedUsers($id);
        }

        // Se a rota tiver nome diferente do Controller
        if (!isset($user->id)) {
            $user = User::find($id);
        }

        $user->delete();

        // API ou Blade
        if ($this->isAPI()) {
            $response['message'] = 'Deletado com sucesso!';
            return response($response, 202);
        } else {
            return redirect()->route('admin.users');
        }

    }

    /**
     * Check if user is a SuperUser
     *
     * @param $id
     * @return bool|void
     */
    private function protectedUsers($id)
    {
        // Users of tests
        if($id <= 6) {
            return $this->apiOrBlade('Este usuário é de TESTES e não pode ser apagado!');
        }

        // SuperUsers
        $user = User::find($id);
        $roleObj = collect([]);
        foreach ($user->roles as $role) {
            $roleObj->push($role->name);
        }
        // dd($roleObj->intersect(['SuperUser'])->count());
        if($roleObj->intersect(['SuperUser'])->count() > 0) {
            return $this->apiOrBlade('Usuário SuperUser não pode ser apagado! Tente remover o papel SuperUser.');
        }

    }

    /**
     * @return bool
     */
    private function isAPI()
    {
        // dd(Route::currentRouteName()); // nome da rota acessada, usado pra filtrar se é API ou Blade
        $routeName = Route::currentRouteName();
        $routeName = substr($routeName, 0, 4);
        return ($routeName == 'api.');

    }

    /**
     * @param string $message
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     */
    private function apiOrBlade($message = 'ACL: Acesso não autorizado!')
    {
        if ($this->isAPI()) {
            $response['message'] = $message;
            return response($response, 403);
        }
        return abort(403, $message);
    }

    /**
     * @param $validator
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function validatorFail($validator)
    {
        // dd($validator);
        if ($this->isAPI()) {
            return response($validator->messages(), 203);
        } else {
            $messages = $validator->messages();
            $replayMessages = '';
            foreach ($messages->all() as $message) {
                $replayMessages .= ' ' . $message;
            }
            return abort(203, $replayMessages);
        }
    }
}
