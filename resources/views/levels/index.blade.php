@extends('layouts.teacher')

@section('content')
<div>
  <show-levels code="{{ $class->code }}" :levels="{{ $levels }}"></show-levels>
</div>
@endsection