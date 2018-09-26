<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Papeis</title>
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

            <div style="padding-top: 15px">
                <form action="{{ route('admin.roles.update',[$record->id]) }}" method="post"
                      style="float: left; padding-right: 5px">
                    <label for="perm">Adicionar Permissões: </label>
                    <select id="perm" name="perm">
                        @foreach($recordPerms as $recordPerm)
                            <option value="{{ $recordPerm->id }}">{{ $recordPerm->name }}</option>
                        @endforeach
                    </select>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="addPerm">
                    <button>ADICIONAR PERMISSÃO</button>
                </form>
            </div>

            <div style="padding-top: 50px">
                <h3>Permissões atribuidos ao pepel: {{ $record->name }}</h3>
                @if (count($record->permissions)>0)
                    @foreach($record->permissions as $perm)
                        <div>
                            <form action="{{ route('admin.roles.update',[$record->id]) }}" method="post">
                                <p style="clear: both; float: left; padding-right: 5px">{{ $perm->name }}</p>
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="removePerm" value="{{ $perm->id }}">
                                <button style="margin-top: 15px">REMOVER PERMISSÃO</button>
                            </form>
                        </div>
                        <br>
                    @endforeach
                @else
                    <p>Papel sem permissão definida!</p>
                @endif
            </div>

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
                        @if (count($iten->permissions)>0)
                            <li>Permissões:</li>
                            <ul>
                                @foreach($iten->permissions as $perm)
                                    <li>{{ $perm->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </ul>

                    @if (!$loop->first)
                        {{--Mesmo que acesse pela URL, até mesmo sendo o SuperAdmin, é bloqueado alterar 'id==1' pelo controller--}}
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
                    @endif
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
        @if ($record->id != 1)
            {{--Mesmo que acesse pela URL, até mesmo sendo o SuperAdmin, é bloqueado alterar 'id==1' pelo controller--}}
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
        @endif

    </div>
@endif
</body>
</html>
