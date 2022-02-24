@extends('layouts.app')

@section('content')
<wordle :available-words="{{ $contents }}"></wordle>
@endsection
