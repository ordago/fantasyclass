@extends('layouts.app')

@section('content')
<div class="p-2 m-2 grid grid4g">
    <div>
      <h4>
        <a href="/classrooms/create" class="bg-info rounded classroom-round card-shadow-s text-center pointer">
          <i class="fal fa-chalkboard-teacher mr-2"></i> {{ __('settings.addClassroom') }}
        </a>
      </h4>
    </div>

  @foreach ($user->classrooms as $classroom)
  <div>
    <h4 style="position: relative;">
      @if($classroom->pivot->is_admin == 1)
        <i class="far fa-user-crown admin" {{ Popper::pop('Admin') }}></i>
      @endif
      <a href="/classrooms/{{ $classroom->code }}" class="p-5 rounded classroom-round card-shadow-s text-center pointer" @if($classroom->getTheme()->type == 0) style="background-color: {{ $classroom->getTheme()->color }}" @else style="background: url('/img/bg/{{ $classroom->getTheme()->name }}');background-size: cover" @endif>
        {{ $classroom->name }}
      </a>
    </h4>
  </div>
  @endforeach
</div>
@endsection