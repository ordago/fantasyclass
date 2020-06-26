@extends('layouts.app')

@section('navbarhide')
style="display:none"
@endsection

@section('content')
<show-event :info="{{ json_encode($return) }}" code="{{ $class->code }}"></settings>
@endsection