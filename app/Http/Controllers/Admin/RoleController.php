<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goToSection = 'index';
        $itens = Role::paginate(50); // limit de 3; Em blade: {{ $itens->links() }}

        // view() -> 'admin' é um diretório >>> views/admin/roles.blade.php
        return view('admin.roles', compact('itens'), compact('goToSection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $goToSection = 'create';

        return view('admin.roles', compact('goToSection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request['name'])

        $data = $request->all();
        // dd($data['name']);

        // Verifica se o nome é unico
        if ((boolean)Role::where('name', '=', $data['name'])->first()) {
            $messageError = 'Já existe um papel com o nome: ' . $data['name'];
            return $messageError;
        }

        Role::create($data);

        return redirect()->route('admin.roles'); // !Não precisa das vars $item e $goToSection, a rota é chamada
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role, $id)
    {
        // dd($role); // como a rota tem nome diferente do controller, essa função não funciona
        $goToSection = 'show';
        $record = Role::find($id);

        // view() -> 'admin' é um diretório >>> views/admin/courses.blade.php
        return view('admin.roles', compact('goToSection'), compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role, $id)
    {
        $goToSection = 'edit';
        $record = Role::find($id);
        $recordPerms = Permission::get();

        return view('admin.roles', compact('goToSection', 'record', 'recordPerms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role, $id)
    {
        $data = $request->all();
        // dd($data);

        // Verifica se não é o SuperAdmin
        if ($id == 1) {
            $messageError = 'Este papel não pode ser alterado!';
            return $messageError;
        }


        if (!isset($role->id)) {
            $role = Role::find($id);
        }

        if (isset($data['perm'])) {
            // dd($data['role']);
            $this->addPerm($data['perm'], $role);
            return redirect()->back();
        }

        if (isset($data['removePerm'])) {
            $this->removePerm($data['removePerm'], $role);
            return redirect()->back();
        }


        // Verifica se o nome não é igual ao de outro papel
        $roleCheck = Role::where('name', '=', $data['name'])->first();
        if (isset($roleCheck) && ($roleCheck->id != $id)) {
            $messageError = 'Já existe um papel com o nome: ' . $data['name'];
            return $messageError;
        }

        // dd($curso->id); // Por segurança buscar pelo id originário($curso) e não o enviado($request)
        $role->update($data);

        // return redirect()->back();
        return redirect()->route('admin.roles'); // !Não precisa das vars $item e $goToSection, a rota é chamada
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role, $id)
    {
        // Verifica se não é o SuperAdmin
        if ($id == 1) {
            $messageError = 'Este papel não pode ser apagado!';
            return $messageError;
        }

        Role::find($id)->delete();
        return redirect()->route('admin.roles');
    }


    /**
     * Add role permissions
     *
     */
    private function addPerm($perm, $role)
    {

        if (is_string($perm)) {
            $perm = Permission::where('id', '=', $perm)->firstOrFail();
        }

        if ($this->checkPerm($perm, $role)) {
            return;
        }

        // roles() -> é um metodo do Model User
        return $role->permissions()->attach($perm);
    }

    /**
     * Check if permission is already role's
     *
     */
    private function checkPerm($perm, $role)
    {

        // roles() -> é um metodo do Model User
        return (boolean)$role->permissions()->find($perm->id);

    }

    /**
     * Remove role permission
     *
     */
    private function removePerm($perm, $role)
    {
        if (is_string($perm)) {
            $perm = Permission::where('id', '=', $perm)->firstOrFail();
        }

        // roles() -> é um metodo do Model User
        return $role->permissions()->detach($perm);
    }
}
