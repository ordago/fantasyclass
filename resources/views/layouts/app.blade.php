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
    <body @yield('bg') class="has-background-white-bis">
    <div id="app">
        @auth
        <nav class="menu-labels card-shadow-s">
            <div class="is-flex align-items-center h-100">
                <a href="/classroom" class="is-flex align-items-center" style="text-decoration: none">
                    <img src="/img/logo.png" width="36px" height="38px" class="has-margin-left-3">
                    <label class="label-title has-padding-left-2 has-margin-0">
                        @yield('title','FantasyClass')
                    </label>
                </a>
                @if(isset($class))
                    @yield('menu')
                @endif

            </div>
            <div class="right-menu-bar">
                    <div class="helpMenu flex-center"  data-toggle="popovermenu"  data-tippy-content="Follow">
                        <a href="https://twitter.com/GamificaOnline" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                    <div class="telegramMenu flex-center" data-toggle="popovermenu"  data-tippy-content="Telegram">
                        <a href="https://t.me/fantasyclass" target="_blank"><i class="fab fa-telegram"></i></a>
                    </div>
                    <div class="patreonMenu flex-center" data-toggle="popovermenu"  data-tippy-content="">
                        <a href="#" onclick=""><i class="fas fa-hand-holding-heart"></i></a>
                    </div>
                    <div class="flex-center settings-menu">
                        <div class="ml-2 flex-center" id="barNotif">

                        </div>

                        <div class="dropdown is-hoverable is-right has-margin-x-4">
                            <div class="dropdown-trigger">
                                <i class="fas fa-user-graduate"></i> <span class="pl-2 text-light cursor-default" title="{{ Auth::user()->username }}">{{ Str::limit(Auth::user()->username, 8, $end='...') }}</span><span class="caret"></span>
                                <span class="icon is-small">
                                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                <div class="dropdown-content">
                                    <span class="dropdown-item cursor-default">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-dark py-2" href="/preferences/edit">
                                        <i class="fal fa-cog"></i> {{ __('menu.profile') }}
                                    </a>
                                    <a class="dropdown-item text-dark py-2" href="{{ route('logout') }}"
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
        </nav>
        @endauth

        <main class="main-content has-padding-3">
            @yield('content')
        </main>
    </div>
    @include('popper::assets')
</body>
</html>
