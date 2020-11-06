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
            <i class="fad fa-store" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.shop') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
  <show-shop code="{{ $class->code }}" :shop="{{ json_encode($shop) }}" :character="{{ json_encode($character) }}" :items="{{ $items }}" :config="{{ $config }}"></show-shop>
@endsection
