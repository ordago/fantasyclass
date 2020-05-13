@extends('layouts.app')

@section('content')
        <add-students>
          {{ csrf_field() }}
        </add-students>
@endsection