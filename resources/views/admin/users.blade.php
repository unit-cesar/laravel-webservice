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

            <div style="padding-top: 15px">
                <form action="{{ route('admin.users.update',[$record->id]) }}" method="post"
                      style="float: left; padding-right: 5px">
                    <label for="role">Adicionar Papel: </label>
                    <select id="role" name="role">
                        @foreach($recordRoles as $recordRole)
                            <option value="{{ $recordRole->id }}">{{ $recordRole->name }}</option>
                        @endforeach
                    </select>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="addRole">
                    <button>ADICIONAR PAPEL</button>
                </form>
            </div>

            <div style="padding-top: 50px">
                <h3>Papeis atribuidos ao usuários: {{ $record->name }}</h3>
                @if (count($record->roles)>0)
                    @foreach($record->roles as $role)
                        <div>
                            <form action="{{ route('admin.users.update',[$record->id]) }}" method="post">
                                <p style="clear: both; float: left; padding-right: 5px">{{ $role->name }}</p>
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="removeRole" value="{{ $role->id }}">
                                <button style="margin-top: 15px">REMOVER PAPEL</button>
                            </form>
                        </div>
                        <br>
                    @endforeach
                @else
                    <p>Usuário sem papel definido!</p>
                @endif
            </div>

        @else
            <p>Registro não encontrado!</p>
        @endif

    </div>
@endif

@if ($goToSection === 'index')
    <div>
        <h3>Lista de Usuários:</h3>
        <ul>
            @foreach($items as $item)
                <li>
                    <ul>
                        <li>Id: {{ $item->id }}</li>
                        <li><a href="{{ route('admin.users.show', $item->id) }}">{{ $item->name }}</a></li>
                        <li>Email: {{ $item->email }}</li>
                        @if (count($item->roles)>0)
                            <li>Papeis:</li>
                            <ul>
                                @foreach($item->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </ul>

                    <div style="padding-top: 10px">
                        <form action="{{ route('admin.users.destroy',[$item->id]) }}" method="post"
                              style="float: left; padding-right: 5px">
                            @csrf
                            @method('DELETE')
                            <button>DELETAR</button>
                        </form>
                        <form action="{{ route('admin.users.edit',[$item->id]) }}" method="post">
                            @csrf
                            @method('GET')
                            <button>EDITAR</button>
                        </form>
                    </div>
                    <hr>
                </li>
            @endforeach
        </ul>
        {{--<div>{{ $items->links() }}</div>--}}
    </div>
@endif

@if ($goToSection === 'show')
    <div>

        <h3>Usuários:</h3>
        <ul>
            <li>Id: {{ $record->id }}</li>
            <li>Usuário: {{ $record->name }}</li>
            <li>Email: {{ $record->email }}</li>

            @if (count($record->roles)>0)
                <li>Papeis:</li>
                <ul>
                    @foreach($record->roles as $role)
                        <li>{{ $role->name }}</li>
                    @endforeach
                </ul>
            @else
                <p>Usuário sem papel definido!</p>
            @endif

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
