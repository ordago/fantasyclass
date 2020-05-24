@extends('layouts.menu')

@section('content')
  <show-challenges :challenges="{{ $challenges }}" code="{{ $class->code }}"></show-challenges>
@endsection