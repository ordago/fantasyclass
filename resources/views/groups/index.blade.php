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
            <i class="fad fa-users" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.groups') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')

<create-group code="{{ $class->code }}" :students="{{ $class->students }}" :groups="{{ $class->grouping->first()->groups }}"></create-group>

@endsection