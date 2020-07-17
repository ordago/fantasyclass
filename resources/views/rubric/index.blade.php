@extends('layouts.teacher')

@section('content')
    <rubric-management :classroom="{{ $class }}" :rubrics="{{ $rubrics }}"></rubric-management>
@endsection