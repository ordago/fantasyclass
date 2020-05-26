@extends('layouts.menu')

@section('content')
  <show-challenges-group :challengesgroup="{{ $challenges }}" code="{{ $class->code }}"></show-challenges-group>
@endsection