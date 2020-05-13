@extends('layouts.menu')

@section('content')
        <add-students>
          {{ csrf_field() }}
        </add-students>
@endsection