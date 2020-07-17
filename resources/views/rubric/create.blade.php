@extends('layouts.teacher')

@section('content')
    <rubric-create :classroom="{{ $class }}"></rubric-create>
@endsection