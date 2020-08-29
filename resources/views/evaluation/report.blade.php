@extends('layouts.teacher')

@section('content')
    <report :classroom="{{ $class }}" :grades="{{ $grades }}" :settings="{{ json_encode($settings) }}"></report>
@endsection