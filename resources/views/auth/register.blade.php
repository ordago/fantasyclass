@extends('layouts.app')

@section('content')
<div class="top-right custom lang rounded" style="width: auto; font-size: 1em">
    <i class="fal fa-globe"></i> <a class="has-text-light" href="/register/es">es</a> <i class="fal fa-ellipsis-v"></i> <a class="has-text-light" href="/register/ca">ca</a> <i class="fal fa-ellipsis-v"></i> <a class="has-text-light" href="/register/en">en</a>
</div>
<div class="box form">
    <div class="has-text-centered">
        <img src="/img/login-logo.png" width="100px" />
    </div>
    <div class="">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="my-3">
                <input id="name" placeholder="{{ __('auth.name') }}" type="text" class="input is-info @error('name') is-danger @enderror" name="name" minlength="3" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="my-3">
                <input id="username" placeholder="{{ __('auth.username') }}" type="text" pattern="[a-zA-Z][a-zA-Z0-9]{3,31}" class="input is-info @error('username') is-danger @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                @error('username')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
                <small class="has-italic-text">{{ __('auth.username_info') }}</small>
            </div>
            <div class="my-3">
                <input id="email" placeholder="{{ __('auth.email') }}" type="email" class="input is-info @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="my-3">
                <input id="password" placeholder="{{ __('auth.password') }}" type="password" class="input is-info @error('password') is-danger @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="my-3">
                <input id="password-confirm" placeholder="{{ __('auth.confirm') }}" type="password" class="input is-info" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="my-3">
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
            <div class="mb-4">
                <p class="mt-4 mb-1">{{ __('auth.teacher_student') }}</p>
                <div class="field">
                    <div class="control has-icons-left">
                        <div class="select w-100 is-expanded">
                            <select style="height: 50px;" class="has-background-light has-text-dark is-expanded" name="type">
                                <option value="0">{{ __('auth.teacher') }}</option>
                                <option value="1">{{ __('auth.student') }}</option>
                            </select>
                        </div>
                        <div class="icon is-small is-left">
                            <i class="fas fa-globe"></i>
                        </div>
                    </div>
                </div>
            </div>

            <article class="message is-warning mb-3">
                <div class="message-body">
                    Registrándote aceptas la policita de privacidad y las condiciones de uso: <a target="_blank" href="/policy">Política de privacidad</a>
                </div>
            </article>

            {!! htmlFormSnippet() !!}

            <div class="my-4">
                <a href="/login" class="button is-info">
                    <i class="fas fa-long-arrow-left"></i>
                </a>
                <button type="submit" class="button is-link">
                    {{ __('auth.register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection