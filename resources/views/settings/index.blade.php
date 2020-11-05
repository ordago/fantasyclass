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
            <i class="fad fa-file-chart-line" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.settings') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<settings :settings="{{ json_encode($settings) }}" :teachers="{{ $teachers }}" :user="{{ auth()->user() }}" :is-admin="{{ $isAdmin ?? 0 }}" :classroom="{{ $class }}"></settings>
@endsection
