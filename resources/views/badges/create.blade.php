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
    <a href="/classroom/{{ $class->code }}/badges">
        <span class="icon is-small">
            <i class="fad fa-award" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.badges') }}</span>
    </a>
</li>
<li class="is-active">
    <a href="#">
        <span class="icon is-small">
          <i class="fad fa-plus" aria-hidden="true"></i>
        </span>
        <span>{{ __('badges.create') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<div class="bg-light p-2 h-100">
  <create-badge code="{{ $class->code }}" @if(isset($badge)) :badge="{{ $badge }}" @endif></create-badge>
</div>
@endsection