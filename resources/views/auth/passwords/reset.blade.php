@extends('layouts.app')

@section('content')


            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        {{ __('Reset Password') }}
                    </p>
                </header>

                <div class="card-body has-padding-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="">
                            <div class="col-md-6">
                                <input id="email" type="email" disabled class="input @error('email') is-danger @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="help is-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                            <div class="has-margin-3">
                                <input id="password" placeholder="{{ __('Password') }}"  type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="help is-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="has-margin-3">
                                <input id="password-confirm" placeholder="{{ __('Confirm Password') }}" type="password" class="input" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="has-margin-3">
                                <button type="submit" class="button is-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

@endsection
