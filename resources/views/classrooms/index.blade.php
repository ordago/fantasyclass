@extends('layouts.app')

@section('content')


<div class="columns is-multiline is-variable is-1 has-margin-y-2">

    <div class="column has-padding-y-2 is-6-tablet is-12-mobile is-3-desktop is-3-fullhdbox">
      <div class="box w-100 h-100 is-flex has-all-centered">
        <h3 class="w-100 has-text-centered">
          <a href="/classroom/create" class="is-rounded text-center pointer">
            <i class="fal fa-chalkboard-teacher mr-2"></i> {{ __('classroom.add') }}
          </a>
          <hr>
          <join-classroom></join-classroom>
        </h3>
      </div>
    </div>

  @foreach ($user->classrooms as $classroom)

  @php 
    $theme = $classroom->theme;
  @endphp
  <div class="column has-padding-y-2 is-6-tablet is-12-mobile is-3-desktop is-3-fullhdbox has-margin-bottom-0 is-flex has-all-centered">
    <div class="box w-100 h-100 d-flex is-relative rounded classroom-round text-center" @if($theme->type == 0) style="background-color: {{ $theme->color }}" @else style="background: url('/img/bg/thumb_{{ $theme->name }}');background-size: cover" @endif>
      <h3 class="is-size-4 has-text-light">
        @if($classroom->pivot->role == 2)
          <span class="admin" {{ Popper::pop(__('classroom.admin')) }}>
            <i class="far fa-user-crown"></i>
          </span>
          <a href="/classroom/{{ $classroom->code }}" class="has-text-light">
            {{ $classroom->name }}
          </a>
          @elseif($classroom->pivot->role == 1)
          <span class="admin" {{ Popper::pop(__('classroom.teacher')) }}>
            <i class="far fa-user-graduate" ></i>
          </span>
          <a href="/classroom/{{ $classroom->code }}" class="has-text-light">
            {{ $classroom->name }}
          </a>
          @else
          <span class="admin" {{ Popper::pop(__('classroom.student')) }}>
            <i class="far fa-user" ></i>
          </span>
          <a href="/classroom/show/{{ $classroom->code }}" class="has-text-light">
            {{ $classroom->adventure_name }}
          </a>
        @endif
      </h3>
    </div>
  </div>
  @endforeach
</div>
@endsection