@extends('layouts.teacher')

@section('content')
<battles :banks="{{ json_encode($banks) }}" :classroom="{{ $class }}"></battles>
@endsection