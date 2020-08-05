@extends('layouts.teacher')

@section('content')
    <tag-management :lines="{{ $lines }}" :rubrics="{{ $rubrics }}" :classroom="{{ $class }}" :tags="{{ $tags }}"></tag-management>
@endsection