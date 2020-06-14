@extends('layouts.teacher')

@section('content')
       <show-student :admin="true" :items="{{ $items }}" :challenges="{{ $challenges }}" :student="{{ $student }}" :classroom="{{ $class }}"></show-student>
@endsection