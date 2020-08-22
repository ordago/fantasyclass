@extends('layouts.teacher')

@section('content')
    <grade :classroom="{{ $class }}" :rubric="{{ json_encode($rubric) }}" :evaluable="{{ $evaluable }}" :students="{{ $students }}"></grade>
@endsection