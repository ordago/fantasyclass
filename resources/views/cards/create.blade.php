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
    <a href="/classroom/{{ $class->code }}/cards">
        <span class="icon is-small">
            <i class="fad fa-club" aria-hidden="true"></i>
        </span>
        <span>Cards</span>
    </a>
</li>
<li class="is-active">
    <a href="#">
        <span class="icon is-small">
          <i class="fad fa-plus" aria-hidden="true"></i>
        </span>
        <span>Create card</span>
    </a>
</li>
@include('layouts.breadcrumbend')
@endsection

@section('content')
<div class="w-100">
  <create-card code="{{ $class->code }}" card="{{ $card ?? '' }}"></create-card>
</div>
@endsection