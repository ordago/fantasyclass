@extends('layouts.app')

@section('content')
<div class="has-text-centered m-0">
       <volume-meter code="{{ $code }}"></volume-meter>
</div>
@endsection