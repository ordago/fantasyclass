@extends('layouts.teacher')

@section('content')
<div>
  <show-behaviours code="{{ $class->code }}" behaviours="{{ $behaviours }}"></show-behaviours>
</div>
@endsection