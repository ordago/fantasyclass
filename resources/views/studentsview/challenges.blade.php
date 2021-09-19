@extends('layouts.student')

@section('content')
       @if(!count($challenges))
              <div class="content rounded m-3 is-flex has-all-centered p-4 has-background-warning">
                     <h1><i class="fas fa-dungeon"></i> {{ __('challenges.challenges_empty') }}</h1>
              </div>
       @else
              <show-challenges-student :cats="{{ $cats }}" :challenges="{{ json_encode(array_reverse($challenges)) }}" code="{{ $class->code }}"></show-challenges-student>
       @endif
<!-- @foreach(array_reverse($challenges) as $challenge)
              <show-challenge class="mb-3" :full="true" :prev-rating="{{ $challenge['rated'] }}" :challenge="{{ json_encode($challenge) }}" :edit="false" :admin="false" code="{{ $class->code }}"></show-challenge>
       @endforeach -->
@endsection