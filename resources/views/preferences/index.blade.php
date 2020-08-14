@extends('layouts.app')

@section('content')

<form method="POST" action="{{ ('preferences/update') }}">
    @csrf
    @method('patch')
    <section class="has-padding-x-3">

        <h1 class="is-size-2"><i class="fal fa-cog faa-spin animated faa-slow"></i> {{__('preferences.preferences') }}</h1>

        <div class="has-margin-y-4">
            <label for="name" class="has-margin-y-2">{{__('preferences.name') }}</label>
            <!-- <input type="text" name="name" required minlength="2" class="input has-margin-y-2"> -->
            <input id="name" placeholder="{{ __('Name') }}" type="text" class="input has-margin-y-2 is-info @error('name') is-danger @enderror" name="name" value="{{ old('name') ?? $user->name}}" required autocomplete="name" autofocus>

            @error('name')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>       

        <div class="has-margin-y-4">
            <label for="current-password" class="has-margin-y-2">{{__('preferences.current_password') }}</label>
            <!-- <input type="password" name="password" required minlength="4" class="input has-margin-y-2"> -->
            <input id="current-password" type="password" class="input has-margin-y-2 is-info @error('password') is-danger @enderror" name="current-password" required autocomplete="current-password">

            @error('password')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="has-margin-y-4">
            <label for="new-password" class="has-margin-y-2">{{__('preferences.new_password') }}</label>
            <!-- <input type="password" name="password" required minlength="4" class="input has-margin-y-2"> -->
            <input id="new-password" type="password" class="input has-margin-y-2 is-info @error('password') is-danger @enderror" name="new-password" required autocomplete="new-password">

            @error('password')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="has-margin-y-4">
            <label for="password_confirmation" class="has-margin-y-2">{{__('preferences.confirm_new_password') }}</label>
            <!-- <input type="password" name="password_confirmation" required minlength="4" class="input has-margin-y-2"> -->
            <input id="password-confirm" type="password" class="input has-margin-y-2 is-info" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="has-margin-y-4 form-group">
            <label for="language" class="has-margin-y-2">{{__('preferences.language') }}</label>
            <select class="form-control input has-margin-y-2 is-info" id="locale">
                @foreach (language()->allowed() as $code => $name)
                    <!-- <a href="{{ language()->back($code) }}">{{ $name }}</a> -->
                    <option value='{{ $code }}'>{{ $name }}</option>
                    
                @endforeach  
            </select>      
        </div>

        <div class="is-flex has-padding-x-4 has-padding-y-4" style="position: fixed; bottom: 0; right: 0;">
            <button class="button is-link">{{__('preferences.edit') }}</button>
        </div> 
    </section>
</form>
@endsection