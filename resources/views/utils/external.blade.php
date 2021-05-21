@extends('layouts.student')

@section('content')
<div class="has-text-centered m-0 p-2">
       <external code="{{ $code }}" :object="{{ $object }}"></external>
</div>
@endsection
