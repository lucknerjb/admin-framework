@layout('admin::layouts.main')

@section('content')
<div class="hero-unit">
    <h1>Hi, {{ $user->username }}!</h1>
    <p>Welcome to the Admin section! Here you can manage content, users and <a href="{{ action('admin::profile') }}">your own profile</a> on the website. Use the menu on top to get started&hellip;</p>
</div>
@endsection