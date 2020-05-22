@extends('layouts.app')

@section('content')
<div class="p-2 grid grid4g">
    <div class="box has-margin-bottom-0 is-flex is-all-centered">
      <h3 class="w-100 has-text-centered">
        <a href="/classroom/create" class="is-rounded text-center pointer">
          <i class="fal fa-chalkboard-teacher mr-2"></i> {{ __('classroom.add') }}
        </a>
        <hr>
        <a href="/classroom/create" class="is-rounded text-center pointer">
          <i class="fal fa-user mr-2"></i> {{ __('classroom.join') }}
        </a>
      </h3>
    </div>

  @foreach ($user->classrooms as $classroom)

  @php 
    $theme = $classroom->theme;
  @endphp
  <div class="box d-flex is-relative rounded classroom-round text-center" @if($theme->type == 0) style="background-color: {{ $theme->color }}" @else style="background: url('/img/bg/thumb_{{ $theme->name }}');background-size: cover" @endif>
    <h3 class="is-size-4 has-text-light">
      @if($classroom->pivot->role == 2)
        <i class="far fa-user-crown admin" {{ Popper::pop(__('classroom.admin')) }}></i>
      @elseif($classroom->pivot->role == 1)
        <i class="far fa-user-graduate admin" {{ Popper::pop(__('classroom.teacher')) }}></i>
      @else
        <i class="far fa-user admin" {{ Popper::pop(__('classroom.student')) }}></i>
      @endif
      <a href="/classroom/{{ $classroom->code }}" class="has-text-light">
        {{ $classroom->name }}
      </a>
    </h3>
  </div>
  @endforeach
</div>
@endsection