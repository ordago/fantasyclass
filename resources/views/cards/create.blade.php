@extends('layouts.menu')

@section('content')
<div class="w-100 bg-light">
  <create-card code="{{ $class->code }}" card="{{ $card ?? '' }}"></create-card>
</div>
@endsection