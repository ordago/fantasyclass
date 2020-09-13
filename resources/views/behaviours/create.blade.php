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
    <a href="/classroom/{{ $class->code }}/behaviours">
        <span class="icon is-small">
            <i class="fad fa-heart" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.behaviours') }}</span>
    </a>
</li>
<li class="is-active">
    <a href="#">
        <span class="icon is-small">
          <i class="fad fa-plus" aria-hidden="true"></i>
        </span>
        <span>{{ __('behaviours.create') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<div class="bg-light p-2 h-100">

  <create-behaviour code="{{ $class->code }}" @if(isset($behaviour)) :behaviour="{{ $behaviour }}" @endif></create-behaviour>
</div>
@endsection