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
    <a href="/classroom/{{ $class->code }}">
        <span class="icon is-small">
            <i class="fad fa-user" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.students') }}</span>
    </a>
</li>
<li class="is-active">
    <a href="#">
        <span class="icon is-small">
            <i class="fad fa-user" aria-hidden="true"></i>
        </span>
        <span>{{  $student-> name }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
       <individual-report :classroom="{{ $class }}" :student="{{ $student }}"></individual-report>
@endsection