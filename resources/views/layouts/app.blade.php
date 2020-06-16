<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FantasyClass') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/90342cb187.js" crossorigin="anonymous"></script>

    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <script src="/js/pace.min.js"></script>

</head>
    <body @if(!isset($class)) class="has-background-info" @else class="has-background-white-ter" @endif @yield('bg', '')>
    <div id="app" @if(isset($admin) && !$admin) class="has-bg-student" @endif>
        @auth
            <nav class="navbar card-shadow-s is-sticky" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                    <a href="/classroom" class="is-flex align-items-center" style="text-decoration: none">
                        <img src="/img/logo.png" width="36px" height="38px" class="has-margin-x-3">
                        <label class="label-title has-padding-x-2 cursor-pointer">
                            @yield('title','FantasyClass')
                        </label>
                    </a>
                <a role="button" class="navbar-burger burger" @click="showNav = !showNav" :class="{ 'is-active': showNav }" aria-label="menu" aria-expanded="false" data-target="navbar">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbar" class="navbar-menu" :class="{ 'is-active': showNav }">
                @if(isset($class))

                @yield('menu')
                
                @endif

                <div class="navbar-end has-text-right">
                    <div class="navbar-item">
                        <div class="dropdown is-right is-hoverable">
                            <div class="dropdown-trigger">
                                <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                <span>
                                    <i class="fas fa-user-graduate"></i> 
                                    <span class="pl-2 text-light cursor-default">
                                        {{ Str::limit(Auth::user()->username, 8, $end='...') }}
                                    </span>
                                </span>
                                <span class="icon is-small">
                                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                                </span>
                                </button>
                            </div>
                            <div class="dropdown-menu has-text-left" id="dropdown-menu" role="menu">
                                <div class="dropdown-content">
                                    <span href="#" class="dropdown-item">
                                        {{ Auth::user()->username }}
                                    </span>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="/preferences/edit">
                                        <i class="fal fa-cog"></i> {{ __('menu.profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fal fa-sign-out"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
            </nav>
        @endauth

        <main class="main-content has-padding-3">
            @yield('content')
        </main>
    </div>
</body>
</html>
