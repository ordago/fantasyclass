@extends('layouts.teacher')

@section('content')
<div>
  <show-maps code="{{ $class->code }}" maps="{{ $maps }}" active-map="{{ $activeMap }}"></show-behaviours>
</div>
@endsection