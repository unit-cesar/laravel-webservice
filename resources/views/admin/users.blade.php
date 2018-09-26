<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Usuários</title>
</head>
<body>

@include('admin.menu')

@if($goToSection === 'create')
    <div>
        <h3>Cadastrar novo usuário:</h3>
        <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" placeholder="Nome do Usuário" name="name"><br>
            <input type="text" placeholder="Email" name="email"><br>
            <button disabled>Cadastrar novo usuário</button>
        </form>
    </div>
@endif

@if($goToSection === 'edit')
    <div>

        @if(isset($record->id))
            <h3>Editar:</h3>
            <form action="{{ route('admin.users.update', $record->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div>Id: {{ $record->id }}</div>
                <input type="text" placeholder="Nome do Usuário" name="name"
                       value="{{ isset($record->name) ? $record->name : '' }}">
                <br>
                <input type="text" placeholder="Email" name="email"
                       value="{{ isset($record->email) ? $record->email : '' }}">

                <br>
                {{--Altera form pra PUT--}}
                {{--<input type="hidden" name="_method" value="put">--}}
                @method('PUT')
                <button>Atualizar usuário</button>
            </form>
        @else
            <p>Registro não encontrado!</p>
        @endif

    </div>
@endif

@if ($goToSection === 'index')
    <div>
        <h3>Lista de Usuários:</h3>
        <ul>
            @foreach($itens as $iten)
                <li>
                    <ul>
                        <li>Id: {{ $iten->id }}</li>
                        <li><a href="{{ route('admin.users.show', $iten->id) }}">{{ $iten->name }}</a></li>
                        <li>Email: {{ $iten->email }}</li>
                        <li>Papel: ??? {{--{{ $record->email }}--}}</li>
                    </ul>

                    <div style="padding-top: 10px">
                        <form action="{{ route('admin.users.destroy',[$iten->id]) }}" method="post"
                              style="float: left; padding-right: 5px">
                            @csrf
                            @method('DELETE')
                            <button>DELETAR</button>
                        </form>
                        <form action="{{ route('admin.users.edit',[$iten->id]) }}" method="post">
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

        <h3>Usuários:</h3>
        <ul>
            <li>Id: {{ $record->id }}</li>
            <li>Usuário: {{ $record->name }}</li>
            <li>Email: {{ $record->email }}</li>
            <li>Papel: ??? {{--{{ $record->email }}--}}</li>
        </ul>

        <div style="padding: 10px 0 10px 0">
            <form action="{{ route('admin.users.destroy',[$record->id]) }}" method="post"
                  style="float: left; padding-right: 5px">
                @csrf
                @method('DELETE')
                <button>DELETAR</button>
            </form>
            <form action="{{ route('admin.users.edit',[$record->id]) }}" method="post">
                @csrf
                @method('GET')
                <button>EDITAR</button>
            </form>
        </div>

    </div>
@endif
</body>
</html>
