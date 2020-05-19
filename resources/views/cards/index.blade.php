@extends('layouts.menu')

@section('content')
<div class="bg-light p-2 h-100">  
  <div class="m-2">
    <a href="/classroom/{{ $class->code }}/cards/create" class="btn btn-success">
      {{ __('cards.create_card') }}
    </a>
    @if(count($cards) < 10)
    <a href="/classroom/{{ $class->code }}/cards/import/default" class="btn btn-primary">
      {{ __('cards.import_default') }}
    </a>
    @endif
  </div>
  <show-cards cards="{{ $cards }}" code="{{ $class->code }}"></show-cards>
</div>
@endsection