@extends('layouts.menu')

@section('content')
<div class="bg-light p-2 h-100">

  <create-behaviour code="{{ $class->code }}" @if(isset($behaviour)) :behaviour="{{ $behaviour }}" @endif></create-behaviour>
</div>
@endsection