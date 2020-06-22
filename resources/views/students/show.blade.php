@extends('layouts.teacher')

@section('content')
       <show-student-info :cards="{{ $cards }}" :admin="true" :items="{{ $items }}" :challenges="{{ $challenges }}" :student="{{ $student }}" :classroom="{{ $class }}"></show-student-info>
@endsection