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
    <a href="/classroom/{{ $class->code }}/shop">
        <span class="icon is-small">
            <i class="fad fa-store" aria-hidden="true"></i>
        </span>
        <span>{{ __('menu.shop') }}</span>
    </a>
</li>
<li class="is-active">
    <a href="#">
        <span class="icon is-small">
            <i class="fad fa-plus" aria-hidden="true"></i>
        </span>
        <span>{{ __('shop.new_item') }}</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
  <shop-create code="{{ $code }}" :item="{{ $item ?? 'null' }}"></shop-create>
@endsection