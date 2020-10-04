@extends('layouts.teacher')

@section('content')
       <show-student-info allcards="{{ $allcards }}" :cards="{{ $cards }}" :evaluation="{{ json_encode($evaluation) }}" :admin="true" :items="{{ $items }}" :challenges="{{ $challenges }}" :student="{{ $student }}" :settings="{{ json_encode($settings) }}" :classroom="{{ $class }}"></show-student-info>
@endsection