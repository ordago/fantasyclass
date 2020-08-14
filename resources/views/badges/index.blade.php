@extends('layouts.teacher')

@section('content')
<div>
  <show-badges code="{{ $class->code }}" badges="{{ $badges }}"></show-badges>
</div>
@endsection