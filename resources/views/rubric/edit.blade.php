@extends('layouts.teacher')

@section('content')
    <rubric-create :rubric-edit="{{ $rubric }}" :classroom="{{ $class }}"></rubric-create>
@endsection