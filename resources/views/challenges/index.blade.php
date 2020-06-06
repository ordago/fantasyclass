@extends('layouts.teacher')

@section('content')
  <show-challenges-group :challengesgroup="{{ $challenges }}" :icon="{{ $class->goal }}" code="{{ $class->code }}"></show-challenges-group>
@endsection