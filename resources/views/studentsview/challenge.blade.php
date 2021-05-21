@extends('layouts.student')

@section('content')
<div class="p-2">
    <show-challenge class="mb-3" :full="true" :prev-rating="{{ $challenge->rated }}" :challenge="{{ json_encode($challenge) }}" :edit="false" :admin="false" code="{{ $class->code }}"></show-challenge>
    <a href="/classroom/show/{{ $class->code }}/challenges" class="button is-dark">{{ __('challenges.show_all') }}</a>
</div>
@endsection