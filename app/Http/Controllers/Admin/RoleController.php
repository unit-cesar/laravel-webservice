<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ACL
        abort_if(Gate::denies('role-view'), 403);

        $goToSection = 'index';
        $itens = Role::paginate(50); // limit de 3; Em blade: {{ $itens->links() }}

        // view() -> 'admin' é um diretório >>> views/admin/roles.blade.php
        return view('admin.roles', compact('itens', 'goToSection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ACL
        abort_if(Gate::denies('role-create'), 403);

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
        // ACL
        abort_if(Gate::denies('role-create'), 403);

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
        // ACL
        abort_if(Gate::denies('role-view'), 403);

        // Se a rota tiver nome diferente do Controller
        if (!isset($role->id)) {
            $role = Role::find($id);
        }

        $goToSection = 'show';
        $record = $role;

        // view() -> 'admin' é um diretório >>> views/admin/courses.blade.php
        return view('admin.roles', compact('goToSection', 'record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role, $id)
    {
        // ACL
        abort_if(Gate::denies('role-update'), 403);

        $this->protectedRoles($id);

        // Se a rota tiver nome diferente do Controller
        if (!isset($role->id)) {
            $role = Role::find($id);
        }

        $goToSection = 'edit';
        $record = $role;
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
        // ACL
        abort_if(Gate::denies('role-update'), 403);

        $this->protectedRoles($id);

        $data = $request->all();
        // dd($data);

        // Se a rota tiver nome diferente do Controller
        if (!isset($role->id)) {
            $role = Role::find($id);
        }

        if (isset($data['perm'])) {
            // dd($data['role']);
            $role->addPerm($data['perm']);
            return redirect()->back();
        }

        if (isset($data['removePerm'])) {
            $role->removePerm($data['removePerm']);
            return redirect()->back();
        }


        // Verifica se o nome não é igual ao de outro papel, exceto o dele mesmo
        $roleCheck = Role::where('name', '=', $data['name'])->first();
        if (isset($roleCheck) && ($roleCheck->id != $id)) {
            $messageError = 'Já existe um papel com o nome: ' . $data['name'];
            return $messageError;
        }

        // dd($course->id); // Por segurança buscar pelo id originário($course) e não o enviado($request)
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
        // ACL
        abort_if(Gate::denies('role-delete'), 403);

        $this->protectedRoles($id);

        Role::find($id)->delete();
        return redirect()->route('admin.roles');
    }

    /**
     * Check if role is a SuperUser or Registered
     *
     * @return boolean
     */
    private function protectedRoles($id)
    {
        // Verifica se não é o SuperAdmin ou Registered
        abort_if(($id == 1) || ($id == 2), 403, 'Este papel não pode ser alterado!');
    }
}
