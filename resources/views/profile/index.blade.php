@extends('layouts.app')

@section('content')
<profile :user="{{ $user }}" :lang="{{ json_encode($lang) }}"></profile>
@endsection