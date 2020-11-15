@extends('layouts.app')

@section('content')
<button class="js-push-btn float has-all-centered" style="display: none!important" v-tippy content="Enable notifications"><i class="fa fa-bell my-float fs-2"></i></button>
<div class="columns p-2 is-multiline is-variable is-1 mt-0">

  <div class="column py-1 is-6-tablet is-12-mobile is-3-desktop is-3-fullhdbox">
    <div class="box w-100 h-100 is-flex has-all-centered">
      <h3 class="w-100 has-text-centered">
        @if($user->is_student == 0 && $user->email)
        <a href="/classroom/create" class="is-rounded text-center pointer">
          <i class="fal fa-chalkboard-teacher mr-2"></i> {{ __('classroom.add') }}
        </a>
        <hr>
        @endif
        <join-classroom></join-classroom>
      </h3>
    </div>
  </div>

  @foreach ($user->classrooms->sortByDesc('id')->sortBy('state') as $classroom)

  @if($classroom->state == 1)
  @php
  $icon = "<i class='far fa-hourglass-end' v-tippy :content='trans.get(\"classroom.finished\")'></i>";
  @endphp
  @elseif($classroom->state == 2)
  @php
  $icon= "<i class='far fa-eye-slash' v-tippy :content='trans.get(\"classroom.disabled\")'></i>";
  @endphp
  @else
  @php
  $icon = "";
  @endphp
  @endif
  @php
  $theme = $classroom->theme;
  @endphp


  @section('notifications')
  <notifications :notifications="{{ $notifications ?? '[]' }}" :user="{{ auth()->user() }}" type="both"></notifications>
  @endsection

  <div class="column py-1 is-6-tablet is-12-mobile is-3-desktop is-3-fullhdbox mb-0 is-flex has-all-centered">
    <div class="box w-100 h-100 d-flex is-relative rounded classroom-round text-center" @if($theme->type == 0) style="background-color: {{ $theme->color }}" @else style="background: url('/img/bg/thumb_{{ $theme->name }}');background-size: cover" @endif>
      <h3 class="is-size-4 has-text-light">
        @if($classroom->pivot->role == 2)
        {!! $icon !!}
        <span class="admin">
          <clone-classroom :classroom="{{ $classroom }}"></clone-classroom>
          <a href="/classroom/{{ $classroom->code }}/edit" class="has-text-white mx-2" {{ Popper::pop(__('menu.config')) }}><i class="far fa-cog"></i></a>
          <span {{ Popper::pop(__('classroom.admin')) }}>
            <i class="far fa-user-crown"></i>
          </span>
        </span>
        <a href="/classroom/{{ $classroom->code }}" class="has-text-light">
          {{ $classroom->name }}
        </a>
        @elseif($classroom->pivot->role == 1)
        {!! $icon !!}
        <span class="admin" {{ Popper::pop(__('classroom.teacher')) }}>
          <i class="far fa-user-graduate"></i>
        </span>
        <a href="/classroom/{{ $classroom->code }}" class="has-text-light">
          {{ $classroom->name }}
        </a>
        @else
        {!! $icon !!}
        <span class="admin" {{ Popper::pop(__('classroom.student')) }}>
          <i class="far fa-user"></i>
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