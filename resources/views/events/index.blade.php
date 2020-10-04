@extends('layouts.teacher')

@section('content')
    <show-events :events="{{ $events }}" :classroom="{{ $class }}" :disabled="{{ $disabled }}"></show-events>
@endsection