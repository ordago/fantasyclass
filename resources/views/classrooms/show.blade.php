@extends('layouts.menu')

@section('content')
<div class="p-2">
  <!-- Utilities -->

    <show-students students="{{ json_encode($class->students) }}" code="{{ $class->code }}"></show-students>
 
</div>
@endsection