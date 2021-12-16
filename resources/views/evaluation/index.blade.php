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
            <i class="fad fa-analytics" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.evaluation') }}</span>
    </a>
</li>
<span class="left-auto is-flex">
    <a class="tag is-info has-text-light" href="/classroom/{{ $class->code }}/rubrics">
        <span class="icon is-small">
            <i class="mx-2 fas fa-tasks-alt"></i>
        </span>
        <span class="is-hidden-mobile">{{ __('evaluation.rubric_management') }}</span>
    </a>
    <a class="tag is-primary has-text-light ml-1" href="/classroom/{{ $class->code }}/evaluation/report">
        <i class="mr-2 fas fa-file-chart-line"></i>
        <span class="is-hidden-mobile">{{ __("evaluation.report") }}</span>
    </a>
    <a class="tag is-dark has-text-light ml-1" @click="$refs.evalgroup.$refs.tags.$data.isPrefsModalActive = true">
        <span class="icon is-small">
            <i class="mx-2 fas fa-cog"></i>
        </span>
        <span class="is-hidden-mobile">{{ __('evaluation.config') }}</span>
    </a>
</span>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<show-evaluations-group ref="evalgroup" :evaluablesgroup="{{ $evaluablesGroup }}" code="{{ $class->code }}"></show-evaluations-group>
@endsection