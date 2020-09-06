@extends('layouts.app')

@php
App::setlocale('ca');
@endphp

@section('content')
<div class="top-right rounded" style="width: auto; font-size: 1em">
    <i class="fal fa-globe"></i> <a class="has-text-light" href="/register/es">es</a> <i class="fal fa-ellipsis-v"></i> <a class="has-text-light" href="/register/ca">ca</a> <i class="fal fa-ellipsis-v"></i> <a class="has-text-light" href="/register/en">en</a>
</div>
<div class="box form">
    <div class="has-text-centered">
        <img src="/img/logo.svg" width="100px" />
    </div>
    <div class="">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="has-margin-y-3">
                <input id="name" placeholder="{{ __('Name') }}" type="text" class="input is-info @error('name') is-danger @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="has-margin-y-3">
                <input id="username" placeholder="{{ __('Username') }}" type="text" pattern="[a-zA-Z][a-zA-Z0-9]{3,31}" class="input is-info @error('username') is-danger @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                @error('username')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
                <small class="has-italic-text">It should start with a letter, 4 character minimum and without special characters, spaces...</small>
            </div>
            <div class="has-margin-y-3">
                <input id="email" placeholder="{{ __('E-Mail Address') }}" type="email" class="input is-info @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="has-margin-y-3">
                <input id="password" placeholder="{{ __('Password') }}" type="password" class="input is-info @error('password') is-danger @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="has-margin-y-3">
                <input id="password-confirm" placeholder="{{ __('Confirm Password') }}" type="password" class="input is-info" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="has-margin-y-3">
                <div class="field">
                    <div class="control has-icons-left">
                        <div class="select w-100 is-expanded">
                            <select style="height: 50px;" class="has-background-light has-text-dark is-expanded" name="locale">
                                <option value="es">Castellano</option>
                                <option value="en">English</option>
                                <option value="ca">Català / Valencià</option>
                            </select>
                        </div>
                        <div class="icon is-small is-left">
                            <i class="fas fa-globe"></i>
                        </div>
                    </div>
                </div>
            </div>



            <div class="has-margin-y-4">
                <button type="submit" class="button is-link">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection