@extends('layouts.app')

@section('content')

<form action="/classroom" method="post">
@csrf
  <create-classroom goals="{{ $goals }}" themes="{{ $themes }}"></create-classroom>
</form>
@endsection