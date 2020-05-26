@extends('layouts.menu')

@section('content')
  <show-challenges-group :challengesgroup="{{ $challenges }}" :icon="{{ dump($class->goal) }}" code="{{ $class->code }}"></show-challenges-group>
@endsection