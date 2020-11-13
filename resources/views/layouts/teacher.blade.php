@extends('layouts.app')

@section('title')
<span style="display:initial" class="pointer" title="{{ $class->name }}">
    <i class="fal fa-chalkboard"></i> {{ Str::limit($class->name, 8, $end='...') }}
</span>
@endsection

@section('notifications')
<notifications :notifications="{{ $notifications ?? '{}' }}" :user="{{ auth()->user() }}" type="teacher" :pending="{{ $pending ?? '{}' }}"></notifications>
@endsection

@section('menu')

<div class="navbar-start">
    <a href="/classroom/{{ $class->code }}" class="navbar-item">
        <i class="fad fa-user mr-2"></i> {{ __('menu.students') }}
    </a>
    <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
            <i class="fad fa-treasure-chest mr-2"></i> {{ __('menu.rewards') }}
        </a>

        <div class="navbar-dropdown">
            <a href="/classroom/{{ $class->code }}/levels" class="navbar-item">
                <i class="fad fa-trophy mr-2"></i> {{ __('menu.levels') }}
            </a>
            <a href="/classroom/{{ $class->code }}/cards" class="navbar-item">
                <i class="fad fa-club mr-2"></i> {{ __('menu.cards') }}
            </a>
            <a href="/classroom/{{ $class->code }}/badges" class="navbar-item">
                <i class="fad fa-award mr-2"></i> {{ __('menu.badges') }}
            </a>
            <a href="/classroom/{{ $class->code }}/behaviours" class="navbar-item">
                <i class="fad fa-heart mr-2"></i> {{ __('menu.behaviours') }}
            </a>
            <a href="/classroom/{{ $class->code }}/shop" class="navbar-item">
                <i class="fad fa-store mr-2"></i> {{ __('menu.shop') }}
            </a>
            <a href="/classroom/{{ $class->code }}/events" class="navbar-item">
                <i class="fad fa-scroll mr-2"></i> {{ __('menu.events') }}
            </a>
            <a href="/classroom/{{ $class->code }}/pets" class="navbar-item">
                <i class="fad fa-dog mr-2"></i> {{ __('menu.pets') }}
            </a>
        </div>
    </div>
    <a href="/classroom/{{ $class->code }}/challenges" class="navbar-item">
        <i class="fad fa-pen-fancy mr-2"></i> {{ __('menu.challenges') }}
    </a>
    <a href="/classroom/{{ $class->code }}/evaluation" class="navbar-item">
        <i class="fad fa-analytics mr-2"></i> {{ __('menu.evaluation') }}
    </a>
    <a href="/classroom/{{ $class->code }}/maps" class="navbar-item">
        <i class="fad fa-map-marked-alt mr-2"></i> {{ __('menu.map') }}
    </a>
    <a href="/classroom/{{ $class->code }}/rules" class="navbar-item">
        <i class="fad fa-pencil-ruler mr-2"></i> {{ __('menu.rules') }}
    </a>
    <a href="/classroom/{{ $class->code }}/settings" class="navbar-item">
        <i class="fad fa-sliders-v-square mr-2"></i> {{ __('menu.settings') }}
    </a>
</div>

@endsection