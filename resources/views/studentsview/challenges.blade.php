@extends('layouts.student')

@section('content')
       @if(!count($challenges))
              <div class="content rounded has-margin-3 is-flex has-all-centered has-padding-4 has-background-warning">
                     <h1><i class="fas fa-dungeon"></i> The adventure hasn't started yet...</h1>
              </div>
       @endif
       @foreach(array_reverse($challenges) as $challenge)
              <show-challenge :full="true" :prev-rating="{{ $challenge['rated'] }}" :challenge="{{ json_encode($challenge) }}" :edit="false" :admin="false" code="{{ $class->code }}"></show-challenge>
       @endforeach
@endsection