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
            <i class="fad fa-mask" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.roles') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<div>
  <show-roles code="{{ $class->code }}" :roles="{{ $roles }}"></show-roles>
</div>
@endsection
