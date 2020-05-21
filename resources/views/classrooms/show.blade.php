@extends('layouts.menu')

@section('bg')
    @php
        $theme = $class->theme;
    @endphp
    @if($theme->type == 0) 
        style="background-color: {{ $theme->color }}" 
    @else 
        style="background: url('/img/bg/{{ $theme->name }}');background-size: cover"
    @endif
@endsection

@section('content')
<div class="">
  <!-- Utilities -->
    <show-students students="{{ json_encode($class->students) }}" behaviours="{{ json_encode($class->behaviours) }}" code="{{ $class->code }}"></show-students>
 
</div>
@endsection