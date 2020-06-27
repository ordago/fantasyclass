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
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=1">

    <script src="/js/pace.min.js"></script>

    <!-- PWA -->

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="apple-mobile-web-app-title" content="FantasyClass">
    <meta name="application-name" content="FantasyClass">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <script type="text/javascript">
        // Initialize the service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/serviceworker.js', {
                scope: '/'
            }).then(function(registration) {
                // Registration was successful
                console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                // registration failed :(
                console.log('Laravel PWA: ServiceWorker registration failed: ', err);
            });
        }
    </script>

</head>

<body @if(!isset($class) && !isset($themes)) class="has-background-info" @else class="has-background-white-ter" @endif @yield('bg', '' )>
    <div id="app" @if(isset($admin) && !$admin) class="has-bg-student" @endif>
        @auth
        <nav class="navbar card-shadow-s is-sticky" role="navigation" aria-label="main navigation" @yield('navbarhide')>
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
                        @yield('notifications')
                        <div class="dropdown is-right is-hoverable">
                            <div class="dropdown-trigger">
                                <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                    <span>
                                        @if(Auth::user()->is_student == 0)
                                            <i class="fas fa-user-graduate"></i>
                                        @else
                                            <i class="fas fa-user"></i>
                                        @endif
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
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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