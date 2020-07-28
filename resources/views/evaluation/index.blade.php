@extends('layouts.teacher')

@section('content')
    <tag-management :rubrics="{{ $rubrics }}" :classroom="{{ $class }}" :tags="{{ $tags }}"></tag-management>
@endsection