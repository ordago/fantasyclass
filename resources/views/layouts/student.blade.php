@extends('layouts.app')

@section('title')
                <span style="display:initial" class="pointer" title="{{ $class->adventure_name }}">
                    <i class="fal fa-chalkboard"></i> {{ Str::limit($class->adventure_name, 8, $end='...') }}
                </span>
@endsection

@section('menu')

<div class="navbar-start">
                        <a href="/classroom/show/{{ $class->code }}" class="navbar-item">
                            <i class="fad fa-users has-margin-right-2"></i> {{ __('menu.users') }}
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

                </div>

@endsection