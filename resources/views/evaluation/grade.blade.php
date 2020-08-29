@extends('layouts.teacher')

@section('content')
    <grade :classroom="{{ $class }}" :settings="{{ json_encode($settings) }}" :rubric="{{ json_encode($rubric) }}" :evaluable="{{ $evaluable }}" :students="{{ $students }}"></grade>
@endsection