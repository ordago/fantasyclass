@extends('layouts.teacher')

@section('breadcrumb')
@include('layouts.breadcrumbstart')
<li class="tag mr-0 pr-0">
    <a href="/classroom/{{ $class->code }}">
        <span class="icon is-small">
            <i class="fad fa-home" aria-hidden="true"></i>
        </span>
        <span>{{ __('general.home') }}</span>
    </a>
</li>
<li class="is-active tag ml-0 pl-0">
    <a href="#">
        <span class="icon is-small">
            <i class="fad fa-sparkles" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.skills') }}</span>
    </a>
</li>
<span class="left-auto is-flex tag is-dark">
    <a class="has-text-light" @click="$refs.skills.$data.isPrefsModalActive = true">
        <span class="icon is-small">
            <i class="mx-2 fas fa-cog"></i>
        </span>
        <span class="is-hidden-mobile">{{ __('menu.config') }}</span>
    </a>
</span>
@include('layouts.breadcrumbend')
@endsection

@section('content')
    <show-skills code="{{ $class->code }}" ref="skills" :settings="{{ json_encode($settings) }}" :skills="{{ $skills }}"></show-skills>
@endsection