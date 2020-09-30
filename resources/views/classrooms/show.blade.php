@extends('layouts.teacher')

@section('content')
@php
$theme = $class->theme;
@endphp
<div class="">
  <!-- Utilities -->
  <show-students :groups="{{ $groups }}" :students="{{ $students }}" :classroom="{{ $class }}"></show-students>

</div>
@endsection