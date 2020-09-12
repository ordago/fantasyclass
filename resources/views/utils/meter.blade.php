@extends('layouts.app')

@section('content')
<div class="has-text-centered has-margin-0">
       <volume-meter code="{{ $code }}"></volume-meter>
</div>
@endsection