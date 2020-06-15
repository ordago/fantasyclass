@extends('layouts.app')

@section('title')
                <span style="display:initial" class="pointer" title="{{ $class->adventure_name }}">
                    <i class="fal fa-chalkboard"></i> {{ Str::limit($class->adventure_name, 8, $end='...') }}
                </span>
@endsection

@section('menu')

<div class="navbar-start">
                        <a href="/classroom/show/{{ $class->code }}" class="navbar-item">
                            <img src="{{ $student->avatar }}"> <span class="has-margin-left-2">{{ Str::limit($student->name, 8, $end='...') }}</span>
                        </a>
                        <a href="/classroom/show/{{ $class->code }}/users" class="navbar-item">
                            <i class="fad fa-users has-margin-right-2"></i> {{ __('menu.students') }}
                        </a> 
                        <a href="/classroom/show/{{ $class->code }}/challenges" class="navbar-item">
                            <i class="fad fa-pen-fancy has-margin-right-2"></i> {{ __('menu.stories') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fad fa-map-marked-alt has-margin-right-2"></i> {{ __('menu.map') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fad fa-pencil-ruler has-margin-right-2"></i> {{ __('menu.rules') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fab fa-creative-commons has-margin-right-2"></i> {{ __('menu.licenses') }}
                        </a>

                </div>

@endsection