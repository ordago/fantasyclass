@extends('layouts.student')

@section('content')
       <show-student :admin="false" :student="{{ $student }}" :classroom="{{ $class }}"></show-student>
@endsection