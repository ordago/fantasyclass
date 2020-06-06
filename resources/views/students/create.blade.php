@extends('layouts.teacher')

@section('content')
        <add-students>
          {{ csrf_field() }}
        </add-students>
@endsection