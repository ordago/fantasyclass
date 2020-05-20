@extends('layouts.menu')

@section('content')
<div>  
  <div class="has-margin-2">
    <a href="/classroom/{{ $class->code }}/cards/create" class="button is-success">
      {{ __('cards.create_card') }}
    </a>
    @if(count($cards) < 10)
    <a href="/classroom/{{ $class->code }}/cards/import/default" class="button is-info">
      {{ __('cards.import_default') }}
    </a>
    @endif
  </div>
  <show-cards cards="{{ $cards }}" code="{{ $class->code }}"></show-cards>
</div>
@endsection