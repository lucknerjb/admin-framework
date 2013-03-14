@layout('admin::layouts.main')

@section('content')
<h1>Profile <small>{{ $user->name }}</small></h1>
{{ Form::open(URL::current(), 'POST', array('class' => 'form-horizontal')) }}

<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
    {{ Form::label('name', 'Name', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="text" name="name" value="{{ $user->name }}" required>
    </div>
</div>

<div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
    {{ Form::label('email', 'Email', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="text" name="email" value="{{ $user->email }}" required>
    </div>
</div>

<div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
    {{ Form::label('password', 'Password', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="password" name="password">
    </div>
</div>

<div class="control-group {{ $errors->has('password_confirmation') ? 'error' : '' }}">
    {{ Form::label('password_confirmation', 'Password Confirmation', array('class' => 'control-label')) }}
    <div class="controls">
        <input type="password" name="password_confirmation">
    </div>
</div>

<div class="form-actions">
    <a href="{{ action('admin') }}" class="btn">&larr; Cancel</a>
    <input type="submit" value="Save Changes" class="btn btn-primary">
</div>

{{ Form::token() }}
{{ Form::close() }}
@endsection