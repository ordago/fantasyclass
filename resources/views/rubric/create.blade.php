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
<li>
    <a href="/classroom/{{ $class->code }}/evaluation">
        <span class="icon is-small">
            <i class="fad fa-analytics" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.evaluation') }}</span>
    </a>
</li>
<li>
    <a href="/classroom/{{ $class->code }}/rubrics">
        <span class="icon is-small">
            <i class="fad fa-tasks-alt" aria-hidden="true"></i>
        </span>
        <span>{{ __('evaluation.rubric_management') }}</span>
    </a>
</li>
<li class="is-active">
    <a href="#">
        <span class="icon is-small">
            <i class="fad fa-plus" aria-hidden="true"></i>
        </span>
        <span>{{ __('evaluation.create_rubric') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
    <rubric-create :classroom="{{ $class }}"></rubric-create>
@endsection