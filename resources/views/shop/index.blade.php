@extends('layouts.teacher')

@section('content')
  <show-shop code="{{ $class->code }}" :character="{{ $character }}" :items="{{ $items }}" :config="{{ $config }}"></show-shop>
@endsection