@extends('layouts.menu')

@section('content')
@php
    $theme = $class->theme;
@endphp
<div class="">
  <!-- Utilities -->
  <show-students bg="{{ $theme->name }}"  students="{{ json_encode($students) }}" behaviours="{{ json_encode($class->behaviours) }}" code="{{ $class->code }}"></show-students>
 
</div>
@endsection