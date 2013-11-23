<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ $title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ Asset::container('header')->styles(); }}
        @yield('styles')
        <meta name="robots" content="noindex, follow">
    </head>
    <body>

        <div class="navbar navbar-fixed-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container">

                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <a class="brand" href="{{ URL::to_action('admin') }}">Admin</a>


                    @if ( ! (Auth::guest()) )
                    <div class="btn-group pull-right">
                        <a class="btn btn-inverse" href="{{ URL::to_action('admin::profile')}}">
                            <i class="icon-user icon-white"></i> {{ Str::limit(Auth::user()->username, 10, '&hellip;') }}
                        </a>
                        <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ URL::to_action('admin::profile')}}">
                                    <i class="icon-edit"></i> Edit Your Profile
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ URL::base() }}" target="_blank">
                                    <i class="icon-home"></i> Visit site</a>
                            </li>
                            <li>
                                <a href="{{ URL::to_action('admin::logout')}}">
                                    <i class="icon-arrow-right"></i> Logout
                                </a>
                            </li>
                        </ul>

                    </div>
                    @endif

                    <div class="nav-collapse collapse">
                        <nav>
                            <ul class="nav">
                                @yield('nav')

                                @include('admin::partials.main_menu')
                            </ul>
                        </nav>
                        @if (isset($search) && $search === true)
                        <form class="navbar-search pull-right" method="GET" action="{{ URL::current() }}">
                            <input type="text" class="search-query span2" placeholder="Search"
                                   name="q" value="{{ Input::get('q') }}">
                        </form>
                        @endif
                    </div><!-- /.nav-collapse -->
                </div><!-- /.container -->
            </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->

        <div class="container">
            <ul class="nav nav-tabs">
                @yield('tabs')

                @include('admin::partials.tabs')
            </ul>
        </div>

        @if( count($errors->all()) > 0 )
        <div class="container">
            @foreach ($errors->all() as $error)
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ $error }}
            </div>
            @endforeach
        </div>
        @endif

        @if( Session::has('error') )
        <div class="container">
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ Session::get('error') }}
            </div>
        </div>
        @endif

        @if( Session::has('success') )
        <div class="container">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ Session::get('success') }}
            </div>
        </div>
        @endif

        @if( Session::has('info') )
        <div class="container">
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ Session::get('info') }}
            </div>
        </div>
        @endif

        <div class="container">
            <div class="row">

                @if (isset($q) && strlen($q) > 0)
                <div class="well well-small">Searching for <code><em>{{ $q }}</em></code></div>
                @endif

                @yield('pagination')
                @yield('content')
                @yield('pagination')
            </div><!-- /.row -->
        </div><!--/container-->
            
            <footer class="footer">
                <p>
                    <small><strong><a href="https://github.com/CodeBinders/admin-framework">Admin Framework</a> for Laravel 3</strong> by <a href="http://www.codebinders.com">CodeBinders</a>
                        | <a href="{{ URL::base() }}">Visit site</a>
                    </small></p>
            </footer>

        {{ Asset::container('footer')->scripts(); }}
        @yield('scripts')
    </body>
</html>
