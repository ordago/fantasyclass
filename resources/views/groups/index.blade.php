@extends('layouts.teacher')

@section('content')

<create-group code="{{ $class->code }}" :students="{{ $class->students }}" :groups="{{ $class->grouping->first()->groups }}"></create-group>

@endsection