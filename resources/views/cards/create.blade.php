@extends('layouts.teacher')

@section('content')
<div class="w-100">
  <create-card code="{{ $class->code }}" card="{{ $card ?? '' }}"></create-card>
</div>
@endsection