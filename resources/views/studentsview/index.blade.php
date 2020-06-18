@extends('layouts.student')

@section('content')
       <show-students-student :students="{{ json_encode($students) }}" :theme="{{ $class->theme }}"></show-students-student>
@endsection