@extends('layouts.menu')

@section('content')
<div>

  <a class="btn btn-primary p-2 mx-3 text-light" href="/classrooms/{{ $class->code }}/students/add">
    Add students
  </a>

  <div class="d-flex">  
  @foreach($class->students as $student)
    @php
      $user = $student->classroom->user;
    @endphp
      <div class="rounded p-4 m-2 bg-dark text-light">
        {{ $student->name }}
      </div>
      @endforeach
    </div>

</div>
@endsection