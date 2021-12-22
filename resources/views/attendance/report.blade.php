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
<li class="tag mr-0 pr-0">
  <a href="/classroom/{{ $class->code }}/attendance">
    <span class="icon is-small">
      <i class="fad fa-calendar" aria-hidden="true"></i>
    </span>
    <span>{{ __('menu.attendance') }}</span>
  </a>
</li>
<li class="is-active tag ml-0 pl-0">
  <a href="#">
    <span class="icon is-small">
      <i class="fad fa-file" aria-hidden="true"></i>
    </span>
    <span>{{ __('attendance.report') }}</span>
  </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<show-data code="{{ $class->code }}" :id="null" type="attendance" :admin="true" :info="{{ $students }}"></show-data>
@endsection