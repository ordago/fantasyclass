@extends('layouts.app')

@section('content')
<h1 class="fantasyTitle">FantasyClass</h1>
<div class="form card-shadow-s rounded">
  <div class="thumbnail"><img src="img/logo.svg" width="200px"/></div>
  <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row mb-2">
                <div class="col-md-12">
                    <input id="username" type="username" placeholder="{{ __('auth.email') }}" class="form-control p-4 mb-1 @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required  autofocus>
                    <!--<input id="email" type="email" placeholder="{{ __('auth.email') }}" class="form-control p-4 mb-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>-->
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-2">
                <div class="col-md-12">
                    <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control p-4 mb-1 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" checked name="remember" style="display: none" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0 mt-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="far fa-lock-open-alt"></i> {{ __('Login') }}
                    </button>
                    <button class="btn buttonLogin" disabled onclick="window.location.href='../oauth2callback.php?redirect=fantasyclass.gamifica.online&admin=1'"><i class="fab fa-google"></i> Google login</button>
                    <div class="d-flex align-items-center">
                        @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                        <i class="fal fa-ellipsis-v pt-1"></i>
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
