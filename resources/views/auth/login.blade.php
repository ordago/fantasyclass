@extends('layouts.app')

@section('content')
<h1 class="fantasyTitle">FantasyClass</h1>
<div class="form cardShadow">
  <div class="thumbnail"><img src="img/logo.svg" width="200px"/></div>

  <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row">
                <div class="col-md-12">
                    <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="form-control p-4 mb-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
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
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
