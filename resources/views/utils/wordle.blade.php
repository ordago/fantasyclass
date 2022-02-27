@extends('layouts.app')

@section('content')
<wordle code="{{ $code }}" :available-words="{{ $contents }}"></wordle>
@endsection
