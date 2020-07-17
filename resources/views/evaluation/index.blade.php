@extends('layouts.teacher')

@section('content')
    <tag-management :classroom="{{ $class }}" :tags="{{ $tags }}"></tag-management>
@endsection