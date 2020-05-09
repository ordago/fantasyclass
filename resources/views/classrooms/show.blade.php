@extends('layouts.menu')

@section('title')
<span style="display:initial" title="{{ $class->name }}">
  {{ Str::limit($class->name, 8, $end='...') }}
</span>
@endsection

@section('content')
<div>
  <h1>{{ $class->name }}</h1>
</div>
@endsection