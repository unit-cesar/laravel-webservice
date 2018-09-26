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
        <h3>Cadastrar novo papel:</h3>
        <form action="{{ route('admin.roles.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" placeholder="Nome do Papel" name="name"><br>
            <input type="text" placeholder="Descrição" name="description"><br>
            <button>Cadastrar novo papel</button>
        </form>
    </div>
@endif

@if($goToSection === 'edit')
    <div>

        @if(isset($record->id))
            <h3>Editar:</h3>
            <form action="{{ route('admin.roles.update', $record->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div>Id: {{ $record->id }}</div>
                <input type="text" placeholder="Nome do Papel" name="name"
                       value="{{ isset($record->name) ? $record->name : '' }}">
                <br>
                <input type="text" placeholder="Descrição" name="description"
                       value="{{ isset($record->description) ? $record->description : '' }}">
                <br>
                {{--Altera form pra PUT--}}
                {{--<input type="hidden" name="_method" value="put">--}}
                @method('PUT')
                <button>Atualizar papel</button>
            </form>
        @else
            <p>Registro não encontrado!</p>
        @endif

    </div>
@endif

@if ($goToSection === 'index')
    <div>
        <h3>Lista de Papeis:</h3>
        <ul>
            @foreach($itens as $iten)
                <li>
                    <ul>
                        <li>Id: {{ $iten->id }}</li>
                        <li>Role: <a href="{{ route('admin.roles.show', $iten->id) }}">{{ $iten->name }}</a></li>
                        <li>Descrição: {{ $iten->description }}</li>
                    </ul>

                    <div style="padding-top: 10px">
                        <form action="{{ route('admin.roles.destroy',[$iten->id]) }}" method="post"
                              style="float: left; padding-right: 5px">
                            @csrf
                            @method('DELETE')
                            <button>DELETAR</button>
                        </form>
                        <form action="{{ route('admin.roles.edit',[$iten->id]) }}" method="post">
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

        <h3>Roles:</h3>
        <ul>
            <li>Id: {{ $record->id }}</li>
            <li>Curso: {{ $record->name }}</li>
            <li>Descrição: {{ $record->description }}</li>
        </ul>

        <div style="padding: 10px 0 10px 0">
            <form action="{{ route('admin.roles.destroy',[$record->id]) }}" method="post"
                  style="float: left; padding-right: 5px">
                @csrf
                @method('DELETE')
                <button>DELETAR</button>
            </form>
            <form action="{{ route('admin.roles.edit',[$record->id]) }}" method="post">
                @csrf
                @method('GET')
                <button>EDITAR</button>
            </form>
        </div>

    </div>
@endif
</body>
</html>
