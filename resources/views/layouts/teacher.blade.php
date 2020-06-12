@extends('layouts.app')

@section('title')
                <span style="display:initial" class="pointer" title="{{ $class->name }}">
                    <i class="fal fa-chalkboard"></i> {{ Str::limit($class->name, 8, $end='...') }}
                </span>
@endsection

@section('menu')

<div class="navbar-start">
                        <a href="/classroom/{{ $class->code }}" class="navbar-item">
                            <i class="fad fa-users has-margin-right-2"></i> {{ __('menu.users') }}
                        </a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">
                                <i class="fad fa-treasure-chest has-margin-right-2"></i> {{ __('menu.rewards') }}
                            </a>

                            <div class="navbar-dropdown">
                                <a href="/classroom/{{ $class->code }}/levels" class="navbar-item">
                                    <i class="fad fa-trophy has-margin-right-2"></i> {{ __('menu.levels') }}
                                </a>
                                <a href="/classroom/{{ $class->code }}/cards" class="navbar-item">
                                    <i class="fad fa-club has-margin-right-2"></i> {{ __('menu.cards') }}
                                </a>
                                <a href="/classroom/{{ $class->code }}/behaviours" class="navbar-item">
                                    <i class="fad fa-heart has-margin-right-2"></i> {{ __('menu.behaviours') }}
                                </a>
                                <a href="/classroom/{{ $class->code }}/shop" class="navbar-item">
                                    <i class="fad fa-store has-margin-right-2"></i> {{ __('menu.shop') }}
                                </a>
                            </div>
                        </div>
                        <a href="/classroom/{{ $class->code }}/challenges" class="navbar-item">
                            <i class="fad fa-pen-fancy has-margin-right-2"></i> {{ __('menu.challenges') }}
                        </a>
                        <a href="/classroom/{{ $class->code }}/evaluation" class="navbar-item">
                            <i class="fas fa-analytics has-margin-right-2"></i> {{ __('menu.evaluation') }}
                        </a>
                        <a href="/classroom/{{ $class->code }}/maps"  class="navbar-item">
                                <i class="fad fa-map-marked-alt has-margin-right-2"></i> {{ __('menu.map') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fad fa-pencil-ruler has-margin-right-2"></i> {{ __('menu.rules') }}
                        </a>
                        <a class="navbar-item">
                            <i class="fad fa-sliders-v-square has-margin-right-2"></i> {{ __('menu.settings') }}
                        </a>
                </div>

@endsection