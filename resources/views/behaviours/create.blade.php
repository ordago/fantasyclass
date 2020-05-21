@extends('layouts.menu')

@section('content')
<div class="bg-light p-2 h-100">
  <create-behaviour code="{{ $class->code }}" behaviour="{{ $behaviour ?? '' }}"></create-behaviour>
</div>
@endsection