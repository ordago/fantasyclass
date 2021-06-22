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
            <i class="fak fa-collection" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.collections') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('help')
@endsection

@section('content')
    <show-collections code="{{ $class->code }}" :collections="{{ json_encode($collections) }}"></show-collections>
@endsection
