@extends('layouts.app')

@section('content')
<div class="p-2 m-2 grid grid3g">
  {{ App::getLocale() }}
    <div class="p-5 bg-light rounded text-center">
      <a  href="/classrooms/create">Create Classroom</a>
    </div>
    
    
  @foreach ($user->classrooms as $classroom)
    <a href="/classrooms/create" class="p-5 bg-light fs-2">
      {{ $classroom->name }}
    </a>
  @endforeach
</div>
@endsection