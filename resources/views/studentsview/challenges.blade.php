@extends('layouts.student')

@section('content')
       @if(!count($challenges))
              <div class="content rounded has-margin-3 is-flex has-all-centered has-padding-4 has-background-warning">
                     <h1><i class="fas fa-dungeon"></i> The adventure hasn't started yet...</h1>
              </div>
       @endif
       @foreach(array_reverse($challenges) as $story)
              <show-challenge :full="true" :challenge="{{ json_encode($story) }}" :edit="false" :admin="false" code="{{ $class->code }}"></show-challenge>
       @endforeach
@endsection