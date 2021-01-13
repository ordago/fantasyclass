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
    <a href="/classroom/{{ $class->code }}/cards">
        <span class="icon is-small">
            <i class="fak fa-deck" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.cards') }}</span>
    </a>
</li>
<li class="is-active">
    <a href="#">
        <span class="icon is-small">
          <i class="fad fa-plus" aria-hidden="true"></i>
        </span>
        <span>{{ __('cards.create_card') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<div class="w-100">
  <create-card code="{{ $class->code }}" card="{{ $card ?? '' }}"></create-card>
</div>
@endsection