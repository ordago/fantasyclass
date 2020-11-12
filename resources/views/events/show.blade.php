@extends('layouts.teacher')


@section('content')
<show-event :info="{{ json_encode($return) }}" code="{{ $class->code }}"></settings>
@endsection