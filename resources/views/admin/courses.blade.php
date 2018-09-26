<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cursos</title>
</head>
<body>

@include('admin.menu')

@if($goToSection === 'create')
    <div>
        <h3>Cadastrar novo curso:</h3>
        <form action="{{ route('admin.courses.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" placeholder="Nome do Curso" name="name"><br>
            <input type="text" placeholder="Descrição" name="description"><br>
            <input type="text" placeholder="Valor" name="price"><br>
            <input type="file" name="image"><br>
            <label for="status">Publicável:</label>
            <input type="checkbox" name="status" id="status" checked><br>
            <button>Cadastrar novo curso</button>
        </form>
    </div>
@endif

@if($goToSection === 'edit')
    <div>

        @if(isset($record->id))
            <h3>Editar:</h3>
            <form action="{{ route('admin.courses.update', $record->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div>Id: {{ $record->id }}</div>
                <input type="text" placeholder="Nome do Curso" name="name"
                       value="{{ isset($record->name) ? $record->name : '' }}">
                <br>
                <input type="text" placeholder="Descrição" name="description"
                       value="{{ isset($record->description) ? $record->description : '' }}">
                <br>
                <input type="text" placeholder="Valor" name="price"
                       value="{{ isset($record->price) ? $record->price : '' }}">
                <br>
                <label for="image">Alterar imagem:</label>
                <input type="file" name="image" id="image">
                <br>
                @if(isset($record->image))
                    <div>
                        <img width="150" src="{{ asset($record->image) }}"/>
                    </div>
                @endif
                <label for="status">Publicável:</label>
                <input type="checkbox" name="status" id="status"
                       value="true" {{ isset($record->status) && $record->status === 'y' ? 'checked' : '' }}><br>
                {{--Altera form pra PUT--}}
                {{--<input type="hidden" name="_method" value="put">--}}
                @method('PUT')
                <button>Atualizar curso</button>
            </form>
        @else
            <p>Registro não encontrado!</p>
        @endif

    </div>
@endif

@if ($goToSection === 'index')
    <div>
        <h3>Lista de Cursos:</h3>
        <ul>
            @foreach($itens as $iten)
                <li>
                    <ul>
                        <li>Id: {{ $iten->id }}</li>
                        <li>Curso: <a href="{{ route('admin.courses.show', $iten->id) }}">{{ $iten->name }}</a></li>
                        <li>Preço: {{ $iten->price }}</li>
                        <li>Descrição: {{ $iten->description }}</li>
                        <li>Publicar: {{ $iten->status === 'y' ? 'sim' : 'não' }}</li>
                        <li>Imagem: {{ isset($iten->image) ? $iten->image : '[Sem imagem]' }}</li>
                    </ul>

                    <div style="padding-top: 10px">
                        <form action="{{ route('admin.courses.destroy',[$iten->id]) }}" method="post"
                              style="float: left; padding-right: 5px">
                            @csrf
                            @method('DELETE')
                            <button>DELETAR</button>
                        </form>
                        <form action="{{ route('admin.courses.edit',[$iten->id]) }}" method="post">
                            @csrf
                            @method('GET')
                            <button>EDITAR</button>
                        </form>
                    </div>
                    <hr>
                </li>
            @endforeach
        </ul>
        {{--<div>{{ $itens->links() }}</div>--}}
    </div>
@endif

@if ($goToSection === 'show')
    <div>

        <h3>Cursos:</h3>
        <ul>
            <li>Id: {{ $record->id }}</li>
            <li>Curso: {{ $record->name }}</li>
            <li>Preço: {{ $record->price }}</li>
            <li>Descrição: {{ $record->description }}</li>
            <li>Publicar: {{ $record->status === 'y' ? 'sim' : 'não' }}</li>
            <li>Imagem: {{ isset($record->image) ? $record->image : '[Sem imagem]' }}</li>
        </ul>

        <div style="padding: 10px 0 10px 0">
            <form action="{{ route('admin.courses.destroy',[$record->id]) }}" method="post"
                  style="float: left; padding-right: 5px">
                @csrf
                @method('DELETE')
                <button>DELETAR</button>
            </form>
            <form action="{{ route('admin.courses.edit',[$record->id]) }}" method="post">
                @csrf
                @method('GET')
                <button>EDITAR</button>
            </form>
        </div>

        @if(isset($record->image))
            <div>
                <img width="80%" src="{{ asset($record->image) }}"/>
            </div>
        @endif

    </div>
@endif
</body>
</html>
