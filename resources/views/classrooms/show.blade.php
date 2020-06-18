@extends('layouts.teacher')

@section('content')
@php
$theme = $class->theme;
@endphp
<div class="">
  <!-- Utilities -->
  <show-students :students="{{ $students }}" :classroom="{{ $class }}"></show-students>

</div>
@endsection