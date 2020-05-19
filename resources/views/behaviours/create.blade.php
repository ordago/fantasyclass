@extends('layouts.menu')

@section('content')
<div class="bg-light p-2 h-100">
  <create-behaviour code="{{ $class->code }}"></create-behaviour>
</div>
@endsection