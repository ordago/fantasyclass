@extends('layouts.teacher')

@section('content')

<question-banks code="{{ $class->code }}" :banks="{{ $banks }}"></question-banks>

@endsection