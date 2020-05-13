@extends('layouts.menu')

@section('title')
<span style="display:initial" title="{{ $class->name }}">
  {{ Str::limit($class->name, 8, $end='...') }}
</span>
@endsection

@section('content')
<div>
  <div class="bg-light m-2 p-3">
    <a href="/classrooms/{{ $class->code }}/students/add">Add students</a>
  </div>

</div>
@endsection