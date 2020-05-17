@extends('layouts.app')

@section('content')
<div class="p-2 grid grid4g">
    <div>
      <h4 class="h-100">
        <a href="/classroom/create" class="bg-info h-100 rounded classroom-round card-shadow-s text-center pointer">
          <i class="fal fa-chalkboard-teacher mr-2"></i> {{ __('classroom.add') }}
        </a>
      </h4>
    </div>

  @foreach ($user->classrooms as $classroom)
  <div>
    <h4 style="position: relative;" class="h-100">
      @if($classroom->pivot->role == 2)
        <i class="far fa-user-crown admin" {{ Popper::pop(__('classroom.admin')) }}></i>
      @elseif($classroom->pivot->role == 1)
        <i class="far fa-user-graduate admin" {{ Popper::pop(__('classroom.teacher')) }}></i>
      @else
        <i class="far fa-user admin" {{ Popper::pop(__('classroom.student')) }}></i>
      @endif
      @php 
        $theme = $classroom->theme;
      @endphp
      <a href="/classroom/{{ $classroom->code }}" class="p-5 h-100 d-flex rounded classroom-round card-shadow-s text-center pointer" @if($theme->type == 0) style="background-color: {{ $theme->color }}" @else style="background: url('/img/bg/{{ $theme->name }}');background-size: cover" @endif>
        {{ $classroom->name }}
      </a>
    </h4>
  </div>
  @endforeach
</div>
@endsection