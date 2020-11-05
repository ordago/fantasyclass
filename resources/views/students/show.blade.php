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
       <show-student-info allcards="{{ $allcards }}" :cards="{{ $cards }}" :evaluation="{{ json_encode($evaluation) }}" :admin="true" :items="{{ $items }}" :challenges="{{ $challenges }}" :student="{{ $student }}" :settings="{{ json_encode($settings) }}" :classroom="{{ $class }}"></show-student-info>
@endsection
