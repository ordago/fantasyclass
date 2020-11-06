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
@include('layouts.breadcrumbend')
@endsection

@section('content')
    <tag-management :settings="{{ json_encode($settings) }}" :lines="{{ $lines }}" :rubrics="{{ $rubrics }}" :classroom="{{ $class }}" :tags="{{ $tags }}"></tag-management>
@endsection
