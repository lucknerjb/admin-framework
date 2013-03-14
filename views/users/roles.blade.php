@layout('admin::layouts.main')

@section('content')
<h1>Roles</h1>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Permissions</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $roles as $role )
        <tr>
            <th>{{ $role->name }}</th>
            <td>
                @foreach ($role->permissions as $perm)
                <span class="label label_info">{{ $perm->name }}</span>
                @endforeach
            </td>
            <td>{{ $role->description }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection