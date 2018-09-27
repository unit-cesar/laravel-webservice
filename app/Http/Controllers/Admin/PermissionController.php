<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goToSection = 'index';
        $itens = Permission::paginate(50); // limit de 3; Em blade: {{ $itens->links() }}

        // view() -> 'admin' é um diretório >>> views/admin/permissions.blade.php
        return view('admin.permissions', compact('itens', 'goToSection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $goToSection = 'create';

        return view('admin.permissions', compact('goToSection'));
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
        if ((boolean)Permission::where('name', '=', $data['name'])->first()) {
            $messageError = 'Já existe uma permissão com o nome: ' . $data['name'];
            return $messageError;
        }

        Permission::create($data);

        return redirect()->route('admin.permissions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission, $id)
    {
        // Se a rota tiver nome diferente do Controller
        if (!isset($permission->id)) {
            $permission = Permission::find($id);
        }

        $goToSection = 'show';
        $record = $permission;

        // view() -> 'admin' é um diretório >>> views/admin/courses.blade.php
        return view('admin.permissions', compact('goToSection', 'record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission, $id)
    {
        // Se a rota tiver nome diferente do Controller
        if (!isset($permission->id)) {
            $permission = Permission::find($id);
        }

        $goToSection = 'edit';
        $record = $permission;

        return view('admin.permissions', compact('goToSection', 'record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission, $id)
    {
        $data = $request->all();
        // dd($data);

        // Se a rota tiver nome diferente do Controller
        if (!isset($permission->id)) {
            $permission = Permission::find($id);
        }

        // Verifica se o nome não é igual ao de outro papel, exceto o dele mesmo
        $permissionCheck = Permission::where('name', '=', $data['name'])->first();
        if (isset($permissionCheck) && ($permissionCheck->id != $id)) {
            $messageError = 'Já existe uma permissão com o nome: ' . $data['name'];
            return $messageError;
        }

        // dd($curso->id); // Por segurança buscar pelo id originário($curso) e não o enviado($request)
        $permission->update($data);

        // return redirect()->back();
        return redirect()->route('admin.permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission, $id)
    {
        Permission::find($id)->delete();
        return redirect()->route('admin.permissions');
    }
}
