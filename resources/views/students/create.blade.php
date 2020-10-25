@extends('layouts.teacher')

@section('content')
        <add-students code="{{ $class->code }}" :modal-visible="{{ $modalVisible }}">
          {{ csrf_field() }}
        </add-students>
@endsection