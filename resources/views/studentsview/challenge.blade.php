@extends('layouts.student')

@section('content')
<show-challenge :full="true" :challenge="{{ json_encode($challenge) }}" :edit="false" :admin="false" code="{{ $class->code }}"></show-challenge>
<a href="/classroom/show/{{ $class->code }}/challenges" class="button is-dark">{{ __('challenges.show_all') }}</a>
@endsection