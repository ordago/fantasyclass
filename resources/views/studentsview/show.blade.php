@extends('layouts.student')

@section('content')
       <show-student-info :cards="{{ $cards }}" :settings="{{ json_encode($settings) }}" :evaluation="{{ json_encode($evaluation) }}" :admin="false" :student="{{ $student }}" :challenges="{{ $challenges }}" :classroom="{{ $class }}" :shop="{{ json_encode($shop) }}"></show-student>
@endsection