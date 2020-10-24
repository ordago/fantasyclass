@extends('layouts.app')

@section('bg', $bg ?? '')

@section('content')
<div class="top-right rounded" style="width: auto; font-size: 1em">
    <i class="fal fa-globe"></i> <a class="has-text-light" href="/login/es">es</a> <i class="fal fa-ellipsis-v"></i> <a class="has-text-light" href="/login/ca">ca</a> <i class="fal fa-ellipsis-v"></i> <a class="has-text-light" href="/login/en">en</a>
</div>
<h1 class="fantasyTitle has-margin-top-4 has-margin-bottom-3">FantasyClass</h1>
<div class="box form has-padding-5">
    <div class="thumbnail has-padding-3"><img src="/img/logo.svg" width="200px" /></div>
    <article class="message is-warning">
        <div class="message-body mb-2">
            {{ __('auth.privacy_info') }} <a target="_blank" href="/policy">{{ __('auth.privacy') }}</a>
        </div>
    </article>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <p class="control has-icons-left">
                <input id="username" type="username" placeholder="{{ __('auth.email') }}" class="input is-info  @error('username') is-danger @enderror" name="username" value="{{ old('username') }}" required autofocus>
                <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                </span>
            </p>
        </div>
        <div class="field">
            <p class="control has-icons-left">
                <input id="password" type="password" placeholder="{{ __('Password') }}" class="input is-info  @error('username') is-danger @enderror" name="password" required autocomplete="current-password">
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </p>
            @error('username')
            <p class="help is-danger">
                {{ $message }}
            </p>
            @enderror
        </div>

        <!-- <input class="form-check-input mb-2" name="remember" type="checkbox" id="remember"> Remember -->

        <div class="">
            <div class="">
                <button type="submit" class="button is-link w-100 has-margin-y-2 p-5">
                    <i class="far fa-lock-open-alt has-margin-right-2"></i> {{ __('auth.login') }}
                </button>
                <a href="{{ url('/auth/redirect/google') }}" class="button is-white w-100 border has-margin-y-2 p-5">
                    <img src="/img/google-logo.svg"> Sign in with Google
                    <!-- <i class="fa fa-google has-margin-right-2"></i> Google -->
                </a>
                @if (Route::has('register'))
                <a class="button is-primary w-100 has-margin-y-2 p-5" href="{{ route('register') }}/{{ $locale ?? '' }}"><i class="fas fa-user-plus has-margin-right-2"></i> {{ __('auth.register') }}</a>
                @endif
                <div class="d-flex align-items-center">
                    <i class="fal fa-ellipsis-v has-margin-top-1 has-margin-x-2"></i>
                    @if (Route::has('password.request'))
                    <a class="nav-link" href="{{ route('password.request') }}">
                        {{ __('auth.forgot') }}
                    </a>
                    @endif
                </div>
                <div class="d-flex align-items-center has-margin-top-4 fs-2 has-text-right">
                    <a target="_blank" href="https://twitter.com/GamificaOnline"><i class="fab fa-twitter"></i></a>
                    <i class="fal fa-ellipsis-v"></i>
                    <a target="_blank" href="https://github.com/climentjoan/fantasyclass"><i class="fab fa-github"></i></a>
                    <i class="fal fa-ellipsis-v"></i>
                    <a target="_blank" href="https://t.me/joinchat/G9NbVFS50HGQdHpEaawZkA"><i class="fab fa-telegram"></i></a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection