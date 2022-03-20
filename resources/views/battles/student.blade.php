@extends('layouts.student')

@section('content')
<battles :classroom="{{ $class }}" :battlestd="{{ $battlestd ?? 0 }}"></battles>
@endsection