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
<span class="left-auto is-flex">
    <a @click="$refs.collections.$data.isPrefsModalActive = true">
        <span class="icon is-small">
            <i class="mx-2 fas fa-cog"></i>
        </span>
        <span class="is-hidden-mobile">{{ __('menu.config') }}</span>
    </a>
</span>
@include('layouts.breadcrumbend')
@endsection

@section('help')
@endsection

@section('content')
    <show-collections ref="collections" :settings="{{ json_encode($settings) }}" code="{{ $class->code }}" :collections="{{ json_encode($collections) }}"></show-collections>
@endsection
