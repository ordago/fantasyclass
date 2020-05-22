@extends('layouts.app')

@section('content')


<div class="columns is-multiline is-variable is-1 has-margin-y-2">

    <div class="column has-padding-y-2 is-6-tablet is-12-mobile is-3-desktop is-3-fullhdbox">
      <div class="box w-100 h-100 is-flex is-all-centered">
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
    </div>

  @foreach ($user->classrooms as $classroom)

  @php 
    $theme = $classroom->theme;
  @endphp
  <div class="column has-padding-y-2 is-6-tablet is-12-mobile is-3-desktop is-3-fullhdbox has-margin-bottom-0 is-flex is-all-centered">
    <div class="box w-100 h-100 d-flex is-relative rounded classroom-round text-center" @if($theme->type == 0) style="background-color: {{ $theme->color }}" @else style="background: url('/img/bg/thumb_{{ $theme->name }}');background-size: cover" @endif>
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
  </div>
  @endforeach
</div>
@endsection