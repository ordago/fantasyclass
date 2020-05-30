@extends('layouts.menu')

@section('content')
       <show-student-teacher :student="{{ $student }}" :chart=" {{ $chart }}" :classroom="{{ $class }}"></show-student-teacher>
@endsection