@extends('layouts.app')

@section('title')
<span style="display:initial" title="{{ $class->name }}">
  {{ \Illuminate\Support\Str::limit($class->name, 8, $end='...') }}
</span>
  @endsection

@section('content')
<div>
  <h1>{{ $class->name }}</h1>
</div>
@endsection