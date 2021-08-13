@extends('layouts.app')

@section('content')

<form @keypress.enter.prevent @if(isset($class)) action="/classroom/{{ $class->code }}" @else action="/classroom" @endif method="post">
@csrf
  @if(isset($class))
    @method('patch')
  @endif
  <create-classroom goals="{{ $goals }}" themes="{{ $themes }}" :classroom="{{ $class ?? 'null' }}"></create-classroom>
</form>
@endsection