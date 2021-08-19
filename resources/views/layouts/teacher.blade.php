@extends('layouts.app')

@section('title')
<span style="display:initial" class="pointer" title="{{ $class->name }}">
    <i class="fal fa-chalkboard"></i> {{ Str::limit($class->name, 8, $end='...') }}
</span>
@endsection

@section('mainLink')
<a href="/classroom/{{ $class->code }}" class="is-flex align-items-center" style="text-decoration: none">
    <label class="label-title px-2 cursor-pointer">
        @yield('title', env('APP_NAME'))
    </label>
</a>
@endsection

@section('notifications')
<notifications code="{{ $class->code }}" :notifications="{{ $notifications ?? '[]' }}" :user="{{ auth()->user() }}" type="teacher" :pending="{{ $pending ?? '[]' }}"></notifications>
<a v-tippy content="Tutorial" target="_blank" href="/tutorial" class="cursor-pointer button has-background-warning-light">
    <i class="fas fa-info-circle" style="font-size: 1.25em"></i>
</a>
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
                <i class="fak fa-deck mr-2"></i> {{ __('menu.cards') }}
            </a>
            <a href="/classroom/{{ $class->code }}/roles" class="navbar-item">
                <i class="fas fa-mask mr-2"></i> {{ __('menu.roles') }}
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
            <a href="/classroom/{{ $class->code }}/monsters" class="navbar-item">
                <i class="fad fa-dragon mr-2"></i> {{ __('menu.monsters') }}
            </a>
            <a href="/classroom/{{ $class->code }}/skills" class="navbar-item">
                <i class="fad fa-sparkles mr-2"></i> {{ __('menu.skills') }}
            </a>
            <a href="/classroom/{{ $class->code }}/collections" class="navbar-item">
                <i class="fak fa-collection mr-2"></i> {{ __('menu.collections') }}
            </a>
        </div>
    </div>

    <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
            <i class="fad fa-pen-fancy mr-2"></i> {{ __('menu.challenges') }}
        </a>

        <div class="navbar-dropdown">
            <a href="/classroom/{{ $class->code }}/challenges" class="navbar-item">
                <i class="fad fa-pen-fancy mr-2"></i> {{ __('menu.challenges') }}
            </a>
            <a href="/classroom/{{ $class->code }}/docmgr" class="navbar-item">
                <i class="fad fa-book mr-2"></i> {{ __('menu.documents') }}
            </a>
        </div>
    </div>
    <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
            <i class="fad fa-analytics mr-2"></i> {{ __('menu.evaluation') }}
        </a>

        <div class="navbar-dropdown">
            <a href="/classroom/{{ $class->code }}/evaluation" class="navbar-item">
                <i class="fad fa-analytics mr-2"></i> {{ __('menu.evaluation') }}
            </a>
            <a href="/classroom/{{ $class->code }}/questions" class="navbar-item">
                <i class="fad fa-question mr-2"></i> {{ __('questions.banks') }}
            </a>
            <a href="/classroom/{{ $class->code }}/rubrics" class="navbar-item">
                <i class="fad fa-tasks-alt mr-2"></i> {{ __('evaluation.rubric_management') }}
            </a>
        </div>
    </div>


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

@push('scripttalk')
<!--Start of Tawk.to Script-->
<script src="{{ asset('js/config.js') }}"></script>

<!-- <script defer>
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = config.TAWK;
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script> -->
<!--End of Tawk.to Script-->
@endpush