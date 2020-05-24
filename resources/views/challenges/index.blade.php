@extends('layouts.menu')

@section('content')
  <show-challenges-group :challenges="{{ $challenges }}" code="{{ $class->code }}"></show-challenges-group>
@endsection