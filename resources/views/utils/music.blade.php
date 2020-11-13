@extends('layouts.app')

@section('content')
<div class="has-text-centered m-0 p-2">
       @foreach($music as $name => $sound)
       <div class="sound">
              <p>{{ $name }}</p>
              <audio src="/music/{{ $sound }}" controls loop>
                     <p>Tu navegador no implementa el elemento audio.</p>
              </audio>
       </div>
       @endforeach
</div>
@endsection
