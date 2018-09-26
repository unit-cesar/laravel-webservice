<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goToSection = 'index';
        $itens = User::paginate(50); // limit de 3; Em blade: {{ $itens->links() }}

        // view() -> 'admin' é um diretório >>> views/admin/users.blade.php
        return view('admin.users', compact('itens'), compact('goToSection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $goToSection = 'create';

        return view('admin.users', compact('goToSection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        // dd($role); // como a rota tem nome diferente do controller, essa função não funciona
        $goToSection = 'show';
        $record = User::find($id);

        // view() -> 'admin' é um diretório >>> views/admin/courses.blade.php
        return view('admin.users', compact('goToSection'), compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, $id)
    {
        // dd($user); // como a rota tem nome diferente do controller, essa função não funciona
        $goToSection = 'edit';
        $record = User::find($id);

        return view('admin.users', compact('goToSection'), compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, $id)
    {
        $data = $request->all();
        // dd($data);

        // dd($curso->id); // Por segurança buscar pelo id originário($curso) e não o enviado($request)
        User::find($id)->update($data);

        // return redirect()->back();
        return redirect()->route('admin.users'); // !Não precisa das vars $item e $goToSection, a rota é chamada
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        User::find($id)->delete();
        return redirect()->route('admin.users');
    }
}
