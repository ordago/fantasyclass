@extends('layouts.app')

@section('bg')
    @php
        $theme = $class->theme;
    @endphp
    @if($theme->type == 0) 
        style="background-color: {{ $theme->color }}" 
    @else 
        style="background: url('/img/bg/{{ $theme->name }}');background-size: cover"
    @endif
@endsection

@section('title')
<span style="display:initial" title="{{ $class->name }}">
  {{ Str::limit($class->name, 8, $end='...') }}
</span>
@endsection

@section('menu')
    <div class="has-padding-2 is-flex menu">
        <a class="has-padding-x-4" href="/classroom/{{ $class->code }}" {{ Popper::theme('dark')->pop(__("menu.user_groups")) }}>
            <i class="fad fa-users"></i>
        </a>

        <div class="dropdown is-hoverable">
            <div class="dropdown-trigger">
                <i class="fad fa-treasure-chest"></i>
                <span class="icon is-small">
                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
            </div>
            <div class="dropdown-menu" id="dropdown-menu4" role="menu">
                <div class="dropdown-content">
                    <a class="dropdown-item has-padding-y-3" href="/classroom/{{ $class->code }}/cards">
                        <i class="fad fa-club"></i> {{ __('menu.cards') }}
                    </a>
                    <a class="dropdown-item has-padding-y-3" href="/classroom/{{ $class->code }}/behaviours">
                        <i class="fad fa-heart"></i> {{ __('menu.behaviours') }}
                    </a>
                </div>
            </div>
        </div>
        <a href="/classroom/{{ $class->code }}/map" class="has-padding-x-4 pl-1"><i class="fad fa-map-marked-alt"></i></a>
        <a href="/classroom/{{ $class->code }}/stories" class="has-padding-x-4"><i class="fad fa-pen-fancy"></i></a>
        <a href="/classroom/{{ $class->code }}/missions" class="has-padding-x-4"><i class="fad fa-tasks"></i></a>
        <a href="/classroom/{{ $class->code }}/store" class="has-padding-x-4"><i class="fad fa-store"></i></a>
        <a href="/classroom/{{ $class->code }}/rules" class="has-padding-x-4"><i class="fad fa-pencil-ruler"></i></a>
        <a href="/classroom/{{ $class->code }}/log" class="has-padding-x-4"><i class="fad fa-file-alt"></i></a>
        <a href="/classroom/{{ $class->code }}/settings" class="has-padding-x-4"><i class="fad fa-sliders-v-square"></i></a>
    </div>
@endsection
