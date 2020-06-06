@extends('layouts.teacher')

@section('content')
       <show-student :admin="true" :items="{{ $items }}" :student="{{ $student }}" :classroom="{{ $class }}"></show-student>
@endsection