@extends('layouts.menu')

@section('content')
<div class="bg-light p-2 h-100">
  <a href="/classroom/{{ $class->code }}/behaviours/create" class="btn btn-primary">Add behaviour</a>
  <div class=" d-flex">  
    @foreach($behaviours as $behaviour)
      <div class="bg-success text-light p-2 rounded m-2">
          <i class="{{ $behaviour->icon }}"></i>
      </div>
    @endforeach
  </div>
</div>
@endsection