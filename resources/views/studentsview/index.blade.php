@extends('layouts.student')

@section('content')
       <show-students-student :character-theme="{{ $class->character_theme }}" :students="{{ json_encode($students) }}" :theme="{{ $class->theme }}"></show-students-student>
@endsection