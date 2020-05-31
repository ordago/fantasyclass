@extends('layouts.app')

@section('content')

<create-group code="{{ $class->code }}" :groups="{{ $class->grouping->first()->groups }}"></create-group>

@endsection