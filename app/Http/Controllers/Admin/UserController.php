<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ACL
        abort_if(Gate::denies('user-view'), 403);

        // if(Gate::denies('user-view')){
        //     abort(403, 'Não autorizado!');
        // }

        $goToSection = 'index';
        $itens = User::paginate(50); // limit de 3; Em blade: {{ $itens->links() }}

        // view() -> 'admin' é um diretório >>> views/admin/users.blade.php
        return view('admin.users', compact('itens', 'goToSection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ACL
        abort_if(Gate::denies('user-create'), 403);

        $goToSection = 'create';

        return view('admin.users', compact('goToSection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ACL
        abort_if(Gate::denies('user-create'), 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        // ACL
        abort_if(Gate::denies('user-view'), 403);

        // dd($role); // como a rota tem nome diferente do controller, essa função não funciona
        $goToSection = 'show';
        $record = User::find($id);

        // view() -> 'admin' é um diretório >>> views/admin/courses.blade.php
        return view('admin.users', compact('goToSection', 'record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, $id)
    {
        // ACL
        abort_if(Gate::denies('user-update'), 403);

        // dd($user); // como a rota tem nome diferente do controller, essa função não funciona
        $goToSection = 'edit';
        $record = User::find($id);
        $recordRoles = Role::get();
        // dd($recordRoles);
        // dd($record->roles);

        return view('admin.users', compact('goToSection', 'record', 'recordRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, $id)
    {
        // ACL
        abort_if(Gate::denies('user-update'), 403);

        $data = $request->all();
        // dd($data);

        // Se a rota tiver nome diferente do Controller
        if (!isset($user->id)) {
            $user = User::find($id);
        }

        if (isset($data['role'])) {
            // dd($data['role']);
            $user->addRole($data['role']);
            return redirect()->back();
        }

        if (isset($data['removeRole'])) {

            // Verifica se não é role 'SuperAdmin' do user com 'id==1'
            abort_if(($data['removeRole'] == 1) && ($user->id == 1), 403, 'Este papel não pode ser removido para este usuário!');

            $user->removeRole($data['removeRole']);
            return redirect()->back();
        }


        // dd($data);
        $user->update($data);
        return redirect()->route('admin.users'); // !Não precisa das vars $item e $goToSection, a rota é chamada
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        // ACL
        abort_if(Gate::denies('user-delete'), 403);

        $this->protectedUsers($id);

        User::find($id)->delete();
        return redirect()->route('admin.users');
    }

    /**
     * Check if user is a SuperUser
     *
     * @return boolean
     */
    private function protectedUsers($id)
    {
        // SuperUser
        $user = User::find($id);
        $roleObj = collect([]);
        foreach ($user->roles as $role) {
            $roleObj->push($role->name);
        }
        // dd($roleObj->intersect(['SuperUser'])->count());
        abort_if($roleObj->intersect(['SuperUser'])->count() > 0, 403,
            'Usuário "SuperUser" não pode ser apagado! Tente remover o papel "SuperUser".');
    }
}
