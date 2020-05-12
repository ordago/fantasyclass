@extends('layouts.app')

@section('content')
<div class="form card-shadow-s my-4 p-5 rounded">
        <div class="text-center pb-4">
                <img src="img/logo.svg" width="100px"/>
        </div>
        <div class="row justify-content-center">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row my-0">
                <label for="name" class="col-12 col-form-label">{{ __('Name') }}</label>

                <div class="col-12">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row my-0">
                <label for="username" class="col-12 col-form-label">{{ __('Username') }}</label>

                <div class="col-12">
                    <input id="username" type="text" pattern="[a-zA-Z][a-zA-Z0-9]{3,31}" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-12">
                    <small class="form-text text-muted mb-0">It should start with a letter, 4 character minimum and without special characters, spaces...</small>
                </div>
            </div>
            <div class="form-group row my-0">
                <label for="email" class="col-12 col-form-label">{{ __('E-Mail Address') }}</label>

                <div class="col-12">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row my-0">
                <label for="password" class="col-12 col-form-label">{{ __('Password') }}</label>

                <div class="col-12">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row my-0">
                <label for="password-confirm" class="col-md-4 col-form-label">{{ __('Confirm Password') }}</label>

                <div class="col-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row my-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
