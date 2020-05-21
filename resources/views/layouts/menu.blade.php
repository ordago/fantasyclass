@extends('layouts.app')

@section('title')
  <span style="display:initial" class="pointer" title="{{ $class->name }}">
      <i class="fal fa-chalkboard"></i> {{ Str::limit($class->name, 8, $end='...') }}
  </span>
@endsection
