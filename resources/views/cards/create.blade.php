@extends('layouts.menu')

@section('content')
<div class="w-100 bg-light">
  <create-card classroom="{{ $class->code }}"></create-card>
</div>
@endsection