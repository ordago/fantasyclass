@extends('layouts.teacher')

@section('content')
  <shop-create code="{{ $code }}" :item="{{ $item ?? 'null' }}"></shop-create>
@endsection