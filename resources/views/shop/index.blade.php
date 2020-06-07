@extends('layouts.teacher')

@section('content')
  <show-shop code="{{ $class->code }}" :items="{{ $items }}" :config="{{ $config }}"></show-shop>
@endsection