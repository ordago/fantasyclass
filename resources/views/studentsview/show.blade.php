@extends('layouts.student')

@section('content')
       <show-student :admin="false" :classroom="{{ $class }}"></show-student>
@endsection