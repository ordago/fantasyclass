@extends('layouts.teacher')

@section('breadcrumb')
@include('layouts.breadcrumbstart')
<li>
    <a href="/classroom/{{ $class->code }}">
        <span class="icon is-small">
            <i class="fad fa-home" aria-hidden="true"></i>
        </span>
        <span>Home</span>
    </a>
</li>
<li>
    <a href="/classroom/{{ $class->code }}/evaluation">
        <span class="icon is-small">
            <i class="fad fa-analytics" aria-hidden="true"></i>
        </span>
        <span>Evaluation</span>
    </a>
</li>
<li class="is-active">
    <a href="#">
        <span class="icon is-small">
            <i class="fad fa-file-chart-line" aria-hidden="true"></i>
        </span>
        <span>Evaluation report</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
    <report :classroom="{{ $class }}" :grades="{{ $grades }}" :settings="{{ json_encode($settings) }}"></report>
@endsection