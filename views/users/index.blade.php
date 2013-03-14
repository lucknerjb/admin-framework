@layout('admin::layouts.main')

@section('content')
<h1>Users</h1>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach( $users->results as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role->name }}</td>
        </tr>
        @endforeach
        <tbody>
</table>
@endsection

@section('pagination')
{{ $users->links() }}
@endsection