@extends('layouts.app')

 @section('notifications')
  <notifications :notifications="{{ $notifications ?? '[]' }}" :user="{{ $user }}" type="both"></notifications>
  @endsection

@section('content')
<button class="js-push-btn float has-all-centered" style="display: none!important" v-tippy content="Enable notifications"><i class="fa fa-bell my-float fs-2"></i></button>
@if($user->username == "demo")
<article class="message is-danger m-2 mt-3">
  <div class="message-body">
  <i class="fas fa-exclamation-triangle"></i> This user is for demo purposes, <strong>don't add real information</strong> and use it only to try the platform without registering. When you are done, logout and go to register.
  </div>
</article>
@endif
<show-classrooms :user="{{ $user }}" :classrooms="{{ $classrooms }}"></show-classrooms>
@endsection