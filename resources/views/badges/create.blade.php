@extends('layouts.teacher')

@section('content')
<div class="bg-light p-2 h-100">
  <create-badge code="{{ $class->code }}" @if(isset($badge)) :badge="{{ $badge }}" @endif></create-badge>
</div>
@endsection