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
@if (isset($bg))
<body {!! $bg !!}>
@else
<body>
@endif
    <div id="app">
            
        @auth
        <!--
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="p-3">FantasyClass</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        
                            <!--<li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                            <!--
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>
        -->

        <nav class="menu-labels card-shadow-s">
            <label title="FantasyClass" class="classroomSelect mobileHidden pl-5">
            <img src="/img/logo.png" class="logoImg">
            <label class="p-3">FantasyClass</label>
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
                        <!--<div class="dropdown">
                        <i class="fas fa-globe-americas"></i>
                        <?php
                        //$languages = ['ca', 'es', 'en'];
                        //if(isset($_COOKIE['lang']))
                        //$current = $_COOKIE['lang'];
                        //else
                        //    $current = 'es';
                        ?>
                            <a>es</a>
                            <div class="dropdown-content">
                                @foreach (Config::get('app.locales') as $locale)
                                    <a href="/locale/{{ $locale }}">{{ $locale }}</a>
                                @endforeach
                            </div>

                        </div>-->

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

        <main class="my-3">
            @yield('content')
        </main>
    </div>
</body>
</html>
