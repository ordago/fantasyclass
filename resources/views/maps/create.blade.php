@extends('layouts.teacher')

@section('content')
<div class="bg-light p-2 h-100">
  <create-map code="{{ $class->code }}" @if(isset($map)) :map="{{ $map }}" @endif></create-behaviour>
</div> 
@endsection