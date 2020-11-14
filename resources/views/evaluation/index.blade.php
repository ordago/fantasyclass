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
            <i class="fad fa-analytics" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.evaluation') }}</span>
    </a>
</li>
<a href="/classroom/{{ $class->code }}" class="left-auto">
    <span class="icon is-small">
        <i class="mr-2 fas fa-cog"></i>
    </span>
    <span>{{ __('evaluation.config') }}</span>
</a>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<show-evaluations-group :evaluablesgroup="{{ $evaluablesGroup }}" code="{{ $class->code }}"></show-evaluations-group>
@endsection
