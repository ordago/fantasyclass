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

</head>
    <body @if (isset($bg)) {!! $bg !!} @endif>

    <div id="app">
        @auth
        <nav class="menu-labels card-shadow-s">
            <div class="d-flex align-items-center h-100">
                <a href="/classrooms" style="text-decoration: none">
                <img src="/img/logo.png" width="48px" height="48px" class="ml-1">
                <label class="label-title pl-2 m-0">
                    @yield('title','FantasyClass')
                </label>
                </a>
            </div>
            <div class="right-menu-bar">
                    <div class="helpMenu flexCenter tryHide"  data-toggle="popovermenu"  data-tippy-content="Follow">
                        <a href="https://twitter.com/GamificaOnline" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                    <div class="telegramMenu flexCenter tryHide" data-toggle="popovermenu"  data-tippy-content="Telegram">
                        <a href="https://t.me/fantasyclass" target="_blank"><i class="fab fa-telegram"></i></a>
                    </div>
                    <div class="patreonMenu flexCenter tryHide" data-toggle="popovermenu"  data-tippy-content="">
                        <a href="#" onclick=""><i class="fas fa-hand-holding-heart"></i></a>
                    </div>
                    <div class="flexCenter settings-menu">
                        <div class="ml-2 flexCenter" id="barNotif">

                        </div>
                        <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link px-2 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-graduate"></i> {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-dark py-2" href="/preferences/edit"><i class="fal fa-cog"></i> Preferences</a>
                                    <a class="dropdown-item text-dark py-2" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fal fa-sign-out"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                    </div>


              </div>
        </nav>
        @endauth

        <main class="mb-1 main-content">
            @yield('content')
        </main>
    </div>
    @include('popper::assets')
</body>
</html>
