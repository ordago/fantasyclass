@extends('layouts.teacher')

@section('content')
  <show-shop code="{{ $class->code }}" :shop="{{ json_encode($shop) }}" :character="{{ json_encode($character) }}" :items="{{ $items }}" :config="{{ $config }}"></show-shop>
@endsection