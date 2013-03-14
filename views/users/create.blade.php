@layout('admin::layouts.main')

@section('content')
<h1>Create User</h1>
{{ Form::open(URL::current(), 'POST', array('class' => 'form-horizontal')) }}

<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
    {{ Form::label('name', 'Name', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="text" name="name" value="{{ Input::old('name') }}" required>
    </div>
</div>

<div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
    {{ Form::label('username', 'Username', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="text" name="username" value="{{ Input::old('username') }}" required>
    </div>
</div>

<div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
    {{ Form::label('email', 'Email', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="text" name="email" value="{{ Input::old('email') }}" required>
    </div>
</div>

<div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
    {{ Form::label('password', 'Password', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="password" name="password" required>
    </div>
</div>

<div class="control-group {{ $errors->has('password_confirmation') ? 'error' : '' }}">
    {{ Form::label('password_confirmation', 'Password Confirmation', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="password" name="password_confirmation" required>
    </div>
</div>

<div class="control-group {{ $errors->has('role') ? 'error' : '' }}">
    {{ Form::label('role', 'Role', array('class' => 'control-label')) }}
    <div class="controls">
        <select name="role">
            <option>--------</option>
            @foreach ( $roles as $role)
            <option value="{{ $role->id }}" {{ (Input::old('role') == $role->id) ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-actions">
    <input type="submit" value="Submit" class="btn btn-primary">
</div>

{{ Form::token() }}
{{ Form::close() }}
@endsection