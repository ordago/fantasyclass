@extends('layouts.app')

@section('notifications')
@if(session()->get('bypass_student'))
<a v-tippy content="{{ __('students.bypass') }}" class="mr-1 cursor-pointer button has-text-light has-background-success" href="/classroom/{{ $class->code }}">
    <i class="fas fa-user-graduate mr-2" style="font-size: 1.25em"></i> {{ __('battles.go_back') }}
</a>
@endif
<notifications code="{{ $class->code }}" :videochats="{{ $videochats ?? '[]' }}" :docs="{{ $docs ?? '[]' }}" :notifications="{{ $notifications ?? '[]' }}" :user="{{ auth()->user() }}" type="student"></notifications>
@endsection

@section('mainLink')
<a href="/classroom/show/{{ $class->code }}" class="is-flex align-items-center" style="text-decoration: none">
    <label class="label-title px-2 cursor-pointer">
        @yield('title', env('APP_NAME'))
    </label>
</a>
@endsection

@section('title')
<span style="display:initial" class="pointer" title="{{ $class->adventure_name }}">
    <i class="fal fa-chalkboard"></i> {{ Str::limit($class->adventure_name, 8, $end='...') }}
</span>
@endsection

@section('menu')
<div class="navbar-start">
    <a href="/classroom/show/{{ $class->code }}" class="navbar-item" style="border-right: 1px solid #aaa; border-radius: 10px;min-width: 120px" v-tippy content="{{ $student->name }}">
        <img class="rounded" src="{{ $student->avatar }}"> <span style="min-width: 70px" class="ml-2 has-text-centered">{{ Str::limit($student->name, 8, $end='...') }}</span>
    </a>
    @php
    settings()->setExtraColumns(['classroom_id' => $class->id]);
    $hide = settings()->get('disable_student_view', 0);
    @endphp
    @if($hide != 1)
    <a href="/classroom/show/{{ $class->code }}/users" class="navbar-item">
        <i class="fad fa-users mr-2"></i> {{ __('menu.students') }}
    </a>
    @endif
    <a href="/classroom/show/{{ $class->code }}/challenges" class="navbar-item">
        <i class="fad fa-pen-fancy mr-2"></i> {{ __('menu.challenges') }}
    </a>
    @if(settings()->get('active_map'))
    <a href="/classroom/show/{{ $class->code }}/map" class="navbar-item">
        <i class="fad fa-map-marked-alt mr-2"></i> {{ __('menu.map') }}
    </a>
    @endif
    <a href="/classroom/show/{{ $class->code }}/rules" class="navbar-item">
        <i class="fad fa-pencil-ruler mr-2"></i> {{ __('menu.rules') }}
    </a>
    <a href="/classroom/show/{{ $class->code }}/licenses" v-if="'{{ $class->background }}'.includes('/bg/base/')" class="navbar-item">
        <i class="fab fa-creative-commons mr-2"></i> {{ __('menu.licenses') }}
    </a>
</div>

@endsection