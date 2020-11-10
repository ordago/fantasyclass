@extends('layouts.app')

@section('content')
<chat current-user-id="{{ auth()->user()->id }}"></chat>
@endsection