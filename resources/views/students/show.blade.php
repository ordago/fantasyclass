@extends('layouts.menu')

@section('content')
       <show-student-teacher :student="{{ $student }}" :classroom="{{ $class }}"></show-student-teacher>
@endsection