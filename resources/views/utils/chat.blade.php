@extends('layouts.app')

@section('content')
<chat :current-user-id="{{ auth()->user()->id }} + ''" current-username="{{ auth()->user()->username }}"></chat>
@endsection