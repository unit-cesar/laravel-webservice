<?php

namespace App\Http\Controllers;

use App\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goToSection = 'index';
        $itens = Curso::all();

        // return $itens;
        return view('cursos', compact('itens'), compact('goToSection'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $goToSection = 'create';

        return view('cursos', compact('goToSection'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso, Request $request)
    {
        $goToSection = 'edit';
        $record = Curso::find($request['id']);
        // dd($request['id']);

        return view('cursos', compact('goToSection'), compact('record'));
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
        Curso::find($request['id'])->update($data); // Id da rota, não enviado por input

        return redirect()->route('admin.courses'); // !Não precisa das vars $item e $goToSection, a rota é chamada
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curso $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso, Request $request)
    {
        Curso::find($request['id'])->delete();
        return redirect()->route('admin.courses');
    }
}
