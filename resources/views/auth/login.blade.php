@extends('layouts.app')

@section('bg', $bg ?? '')

@section('content')
<div class="top-right rounded" style="width: auto; font-size: 1em">
    <i class="fal fa-globe"></i> <a class="has-text-light" href="/login/es">es</a> <i class="fal fa-ellipsis-v"></i> <a class="has-text-light" href="/login/ca">ca</a> <i class="fal fa-ellipsis-v"></i> <a class="has-text-light" href="/login/en">en</a>
</div>
<h1 class="fantasyTitle has-margin-top-4 has-margin-bottom-3">FantasyClass</h1>
<div class="box form has-padding-5">
  <div class="thumbnail has-padding-3"><img src="/img/logo.svg" width="200px"/></div>
  <form method="POST" action="{{ route('login') }}">
            @csrf

                <div class="field">
                <p class="control has-icons-left">
                    <input id="username" type="username" placeholder="{{ __('auth.email') }}" class="input is-info  @error('username') is-danger @enderror" name="username" value="{{ old('username') }}" required  autofocus>
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

            <input class="form-check-input" type="checkbox" checked name="remember" style="display: none" id="remember">
       
            <div class="">
                <div class="">
                    <button type="submit" class="button is-link w-100 has-margin-y-2">
                        <i class="far fa-lock-open-alt has-margin-right-2"></i> {{ __('Login') }}
                    </button>
                    <a href="{{ url('/auth/redirect/google') }}" class="button is-danger w-100 has-margin-y-2"><i class="fa fa-google has-margin-right-2"></i> Google</a>
                    @if (Route::has('register'))
                    <a class="button is-primary w-100 has-margin-y-2" href="{{ route('register') }}/{{ $locale ?? '' }}"><i class="fas fa-user-plus has-margin-right-2"></i> {{ __('Register') }}</a>
                    @endif
                    <div class="d-flex align-items-center">
                        <i class="fal fa-ellipsis-v has-margin-top-1 has-margin-x-2"></i>
                        @if (Route::has('password.request'))
                            <a class="nav-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
