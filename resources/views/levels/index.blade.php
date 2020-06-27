@extends('layouts.teacher')

@section('content')
<div>
  @if(!count($levels))
    <create-levels></create-levels>
  @else
        @php
          $last = false;
        @endphp
    <div class="columns is-multiline is-variable has-margin-top-3">
    @foreach($levels as $level)
        @if($loop->last)
            @php
              $last = true;
            @endphp
        @endif
            <show-level code="{{ $class->code }}" :edit="true" last="{{ $last }}" :level="{{ $level }}"></show-level>
    @endforeach
    </div>

  @endif
</div>
@endsection