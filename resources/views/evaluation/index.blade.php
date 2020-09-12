@extends('layouts.teacher')

@section('content')
<tag-management :settings="{{ json_encode($settings) }}" :lines="{{ $lines }}" :rubrics="{{ $rubrics }}" :classroom="{{ $class }}" :tags="{{ $tags }}"></tag-management>
@endsection