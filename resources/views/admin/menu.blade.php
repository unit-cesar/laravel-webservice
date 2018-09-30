<p style="position: sticky; top: 1px; padding: 5px; background-color: #cae8ca; border: 2px solid #4CAF50;">
    User <strong>{{ Auth::user()->name }}</strong> autenticado!
</p>
<ul>
    <li>
        <a href="{{ route('root') }}">HOME > Site</a>
    </li>
</ul>
<ul>
    <li>
        <a href="{{ route('admin.') }}">HOME > Admin</a>
    </li>
</ul>
@can('user-view')
<ul>
    <li>
        <a href="{{ route('admin.users') }}">USUÁRIOS</a>
    </li>
</ul>
@endcan
@can('role-view')
<ul>
    <li>
        <a href="{{ route('admin.roles') }}">PAPEIS</a>
    </li>
    @can('role-create')
    <li>
        <a href="{{ route('admin.roles.create') }}">CADASTRAR NOVO PAPEL</a>
    </li>
    @endcan
</ul>
@endcan
@can('permission-view')
    <ul>
        <li>
            <a href="{{ route('admin.permissions') }}">PERMISSÕES</a>
        </li>
        @can('permission-create')
            <li>
                <a href="{{ route('admin.permissions.create') }}">CADASTRAR NOVA PERMISSÃO</a>
            </li>
        @endcan
    </ul>
@endcan
@can('course-view')
    <ul>
        <li>
            <a href="{{ route('admin.courses') }}">CURSOS</a>
        </li>
        @can('course-create')
            <li>
                <a href="{{ route('admin.courses.create') }}">CADASTRAR NOVO CURSO</a>
            </li>
        @endcan
    </ul>
@endcan
