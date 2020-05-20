@extends('layouts.menu')

@section('content')
<div class="bg-light p-2 h-100">
  <a href="/classroom/{{ $class->code }}/behaviours/create" class="btn btn-primary">{{ __('behaviours.add') }}</a>
  <!--<div class="d-flex flex-wrap">  
    @foreach($behaviours as $behaviour)
      @php
        if(($behaviour->xp + $behaviour->hp + $behaviour->gold) >= 0)
          $style = "bg-success";
        else
          $style = "bg-danger";
      @endphp
      <div class="{{ $style }} text-light p-3 rounded m-2 d-flex flex-column flex-wrap" style="justify-content: space-between">
          <i class="{{ $behaviour->icon }}"></i> {{ $behaviour->name }}
          @if($behaviour->custom_text)
          <div>
            <small>{{ $behaviour->custom_text }}</small>
          </div>
          @endif
          <div class="pt-2">
            <button class="btn btn-secondary"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
          </div>
      </div>
    @endforeach
  </div>-->
  <show-behaviours behaviours="{{ $behaviours }}"></show-behaviours>
</div>
@endsection