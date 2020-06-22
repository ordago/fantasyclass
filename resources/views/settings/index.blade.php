@extends('layouts.teacher')

@section('content')
<settings :settings="{{ json_encode($settings) }}" :teachers="{{ $teachers }}" :user="{{ $user }}" :is-admin="{{ $isAdmin ?? 0 }}" :classroom="{{ $class }}"></settings>
@endsection