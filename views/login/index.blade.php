@layout('admin::layouts.main')

@section('content')

{{ Form::open(URL::current(), 'POST', array('class' => 'form-signin')) }}
<h1 class="form-signin-heading">Login</h1>
<div>
    {{ Form::label('username', 'Username') }}
    {{ Form::text('username') }}
</div>
<div>
    {{ Form::label('password', 'Password') }}
    {{ Form::password('password') }}
</div>
{{ Form::submit('Login', array('class' => 'btn btn-large btn-primary')) }}
{{ Form::token() }}
{{ Form::close() }}

@endsection