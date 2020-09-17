@extends('layouts.app')

@section('title')
<span style="display:initial" class="pointer" title="{{ $class->adventure_name }}">
    <i class="fal fa-chalkboard"></i> {{ Str::limit($class->adventure_name, 8, $end='...') }}
</span>
@endsection

@section('menu')
<div class="navbar-start">
    <a href="/classroom/show/{{ $class->code }}" class="navbar-item" v-tippy content="{{ $student->name }}">
        <img class="rounded" src="{{ $student->avatar }}"> <span style="min-width: 70px" class="has-margin-left-2">{{ Str::limit($student->name, 8, $end='...') }}</span>
    </a>
    <a href="/classroom/show/{{ $class->code }}/users" class="navbar-item">
        <i class="fad fa-users has-margin-right-2"></i> {{ __('menu.students') }}
    </a>
    <a href="/classroom/show/{{ $class->code }}/stories" class="navbar-item">
        <i class="fad fa-pen-fancy has-margin-right-2"></i> {{ __('menu.stories') }}
    </a>
    @php
    settings()->setExtraColumns(['classroom_id' => $class->id]);
    @endphp
    @if(settings()->get('active_map'))
    <a href="/classroom/show/{{ $class->code }}/map" class="navbar-item">
        <i class="fad fa-map-marked-alt has-margin-right-2"></i> {{ __('menu.map') }}
    </a>
    @endif
    <a href="/classroom/show/{{ $class->code }}/rules" class="navbar-item">
        <i class="fad fa-pencil-ruler has-margin-right-2"></i> {{ __('menu.rules') }}
    </a>
    <a href="/classroom/show/{{ $class->code }}/licenses" class="navbar-item">
        <i class="fab fa-creative-commons has-margin-right-2"></i> {{ __('menu.licenses') }}
    </a>
</div>

@endsection