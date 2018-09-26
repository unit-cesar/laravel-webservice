<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Permissão</title>
</head>
<body>

@include('admin.menu')

@if($goToSection === 'create')
    <div>
        <h3>Cadastrar nova permissão:</h3>
        <form action="{{ route('admin.permissions.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" placeholder="Nome da Permissão" name="name"><br>
            <input type="text" placeholder="Descrição" name="description"><br>
            <button disabled>Cadastrar novo curso</button>
        </form>
    </div>
@endif

@if($goToSection === 'edit')
    <div>

        @if(isset($record->id))
            <h3>Editar:</h3>
            <form action="{{ route('admin.permissions.update', $record->id) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div>Id: {{ $record->id }}</div>
                <input type="text" placeholder="Nome da Permissão" name="name"
                       value="{{ isset($record->name) ? $record->name : '' }}">
                <br>
                <input type="text" placeholder="Descrição" name="description"
                       value="{{ isset($record->description) ? $record->description : '' }}">
                <br>
                {{--Altera form pra PUT--}}
                {{--<input type="hidden" name="_method" value="put">--}}
                @method('PUT')
                <button disabled>Atualizar permissão</button>
            </form>
        @else
            <p>Registro não encontrado!</p>
        @endif

    </div>
@endif

@if ($goToSection === 'index')
    <div>
        <h3>Lista de Permissões:</h3>
        <ul>
            @foreach($itens as $iten)
                <li>
                    <ul>
                        <li>Id: {{ $iten->id }}</li>
                        <li>Permissão: <a href="{{ route('admin.permissions.show', $iten->id) }}">{{ $iten->name }}</a>
                        </li>
                        <li>Descrição: {{ $iten->description }}</li>
                    </ul>

                    <div style="padding-top: 10px">
                        <form action="{{ route('admin.permissions.destroy',[$iten->id]) }}" method="post"
                              style="float: left; padding-right: 5px">
                            @csrf
                            @method('DELETE')
                            <button disabled>DELETAR</button>
                        </form>
                        <form action="{{ route('admin.permissions.edit',[$iten->id]) }}" method="post">
                            @csrf
                            @method('GET')
                            <button disabled>EDITAR</button>
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

        <h3>Permissão:</h3>
        <ul>
            <li>Id: {{ $record->id }}</li>
            <li>Curso: {{ $record->name }}</li>
            <li>Descrição: {{ $record->description }}</li>
        </ul>

        <div style="padding: 10px 0 10px 0">
            <form action="{{ route('admin.permissions.destroy',[$record->id]) }}" method="post"
                  style="float: left; padding-right: 5px">
                @csrf
                @method('DELETE')
                <button disabled>DELETAR</button>
            </form>
            <form action="{{ route('admin.permissions.edit',[$record->id]) }}" method="post">
                @csrf
                @method('GET')
                <button disabled>EDITAR</button>
            </form>
        </div>

    </div>
@endif
</body>
</html>
