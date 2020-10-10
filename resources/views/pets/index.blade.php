@extends('layouts.teacher')

@section('content')
    <show-pets code="{{ $class->code }}" :pets="{{ $pets }}"></show-pets>
@endsection