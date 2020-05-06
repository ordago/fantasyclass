@extends('layouts.app')

@section('content')
<div class="p-2 m-2 grid grid4g">
    <div class="">
      <h4>
        <a href="/classrooms/create" class="p-5 bg-light rounded classroom-round card-shadow-s text-center pointer">Create Classroom</a>
      </h4>
    </div>
    
    
  @foreach ($user->classrooms as $classroom)
    <a href="/classrooms/create" class="p-5 bg-light fs-2">
      {{ $classroom->name }}
    </a>
  @endforeach
</div>
@endsection