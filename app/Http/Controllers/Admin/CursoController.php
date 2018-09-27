<?php

namespace App\Http\Controllers\Admin;

use App\Curso;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ACL
        abort_if(Gate::denies('curso-view'), 403);

        $goToSection = 'index';
        // $itens = Curso::all(); // Todos
        $itens = Curso::paginate(3); // limit de 3; Em blade: {{ $itens->links() }}


        // view() -> 'admin' é um diretório >>> views/admin/courses.blade.php
        return view('admin.courses', compact('itens'), compact('goToSection'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ACL
        abort_if(Gate::denies('curso-create'), 403);

        $goToSection = 'create';

        return view('admin.courses', compact('goToSection'));
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
        abort_if(Gate::denies('curso-create'), 403);

        // dd($request->all());
        // dd($request['name'])

        $data = $request->all();
        $dir = 'img/cursos/';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $microtime = preg_replace('/[[:punct:].[:space:]]/', '', microtime()); // remove espaços pontuações
            $ext = $image->guessClientExtension(); //retorna a extensão do arquivo
            $imageName = 'img_'.$microtime.'.'.$ext; // Deve-se criar uma tabela especifica de imagem e add o id da imagem no nome
            $image->move($dir, $imageName);
            $data['image'] = $dir.$imageName;
        } else {
            $data['image'] = $dir.'default.png';
        }

        if (isset($data['status'])) {
            $data['status'] = 'y';
        } else {
            $data['status'] = 'n';
        }

        // dd($data);
        Curso::create($data);

        return redirect()->route('admin.courses'); // !Não precisa das vars $item e $goToSection, a rota é chamada
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        // ACL
        abort_if(Gate::denies('curso-view'), 403);

        $goToSection = 'show';
        $record = Curso::find($curso->id);

        // view() -> 'admin' é um diretório >>> views/admin/courses.blade.php
        return view('admin.courses', compact('goToSection'), compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        // ACL
        abort_if(Gate::denies('curso-update'), 403);

        // dd($curso); // Nome do Controller
        $goToSection = 'edit';
        $record = Curso::find($curso->id);

        return view('admin.courses', compact('goToSection'), compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        // ACL
        abort_if(Gate::denies('curso-update'), 403);

        $data = $request->all();
        $dir = 'img/cursos/';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $microtime = preg_replace('/[[:punct:].[:space:]]/', '', microtime()); // remove espaços pontuações
            $ext = $image->guessClientExtension(); //retorna a extensão do arquivo
            $imageName = 'img_'.$microtime.'.'.$ext; // Deve-se criar uma tabela especifica de imagem e add o id da imagem no nome
            $image->move($dir, $imageName);
            $data['image'] = $dir.$imageName;
        } else {
            // Nada a fazer, mantem a imagem, não altera!
        }

        if (isset($data['status'])) {
            $data['status'] = 'y';
        } else {
            $data['status'] = 'n';
        }

        // dd($data);
        // dd($curso->id); // Por segurança buscar pelo id originário($curso) e não o enviado($request)
        Curso::find($curso->id)->update($data); // Id da rota, não enviado por input
        // $curso->update($data);

        // return redirect()->back();
        return redirect()->route('admin.courses'); // !Não precisa das vars $item e $goToSection, a rota é chamada
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        // ACL
        abort_if(Gate::denies('curso-delete'), 403);

        Curso::find($curso->id)->delete();
        return redirect()->route('admin.courses');
    }
}
