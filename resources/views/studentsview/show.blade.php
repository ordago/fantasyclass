@extends('layouts.student')

@section('content')
       <show-student :admin="false" :student="{{ $student }}" :challenges="{{ $challenges }}" :classroom="{{ $class }}" :shop="{{ json_encode($shop) }}"></show-student>
@endsection