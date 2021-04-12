@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-title">
                        {{ __('Verify Your Email Address') }} : <mark class="mx-2 p-1">{{ auth()->user()->email }}</mark> (not correct? <a class="ml-2 tag is-info" href="/profile">Go to Profile and update it</a>)
                    </div>
                </div>

                <div class="card-body p-3">
                    @if (session('resent'))
                        <div class="alert alert-success my-3" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    <p class="py-4">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email, check your spam box or update the e-mail if is not correct') }}.
                    </p>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="button is-primary">{{ __('Click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
