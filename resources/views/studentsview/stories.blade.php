@extends('layouts.student')

@section('content')
       @foreach(array_reverse($stories) as $story)
              <show-challenge :full="true" :challenge="{{ json_encode($story) }}" :edit="false" :admin="false" code="{{ $class->code }}"></show-challenge>
       @endforeach
@endsection