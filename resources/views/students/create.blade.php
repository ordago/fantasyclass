@extends('layouts.teacher')

@section('content')
        <add-students code="{{ $class->code }}">
          {{ csrf_field() }}
        </add-students>
@endsection