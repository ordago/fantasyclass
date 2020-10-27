@extends('layouts.teacher')

@section('content')
<div>  
  <show-cards cards="{{ $cards }}" code="{{ $class->code }}"></show-cards>
</div>
@endsection