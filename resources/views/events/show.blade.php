@extends('layouts.teacher')

@section('breadcrumb')
@include('layouts.breadcrumbstart')
<li>
    <a href="/classroom/{{ $class->code }}">
        <span class="icon is-small">
            <i class="fad fa-home" aria-hidden="true"></i>
        </span>
        <span>{{ __('general.home') }}</span>
    </a>
</li>
<li class="is-active">
    <a href="#">
        <span class="icon is-small">
            <i class="fad fa-scroll" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.events') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<show-event :info="{{ json_encode($return) }}" code="{{ $class->code }}"></settings>
@endsection