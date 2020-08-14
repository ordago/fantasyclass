@extends('layouts.teacher')

@section('content')

<edit-rules code="{{ $class->code }}" :rules="{{ $rules }}"></edit-rules>

@endsection