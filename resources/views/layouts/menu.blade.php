@extends('layouts.app')

@section('menu')
    <div class="pl-2 h-100 d-flex menu">
        <a href="/classrooms/{{ $class->code }}" class="h-100 py-3 pl-3 pr-2 d-flex align-items-center" {{ Popper::theme('dark')->pop('Users and groups') }}><i class="fad fa-users"></i></a>
        <li class="nav-item dropdown h-100 p-2 d-flex align-items-center">
            <a id="navbarDropdown" class="nav-link h-100 p-3 d-flex align-items-center dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="fad fa-treasure-chest"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                
            </div>
        </li>
        <a href="/classrooms/{{ $class->code }}/map" class="h-100 py-3 pr-3 pl-1 d-flex align-items-center"><i class="fad fa-map-marked-alt"></i></a>
        <a href="/classrooms/{{ $class->code }}/stories" class="h-100 p-3 d-flex align-items-center"><i class="fad fa-pen-fancy"></i></a>
        <a href="/classrooms/{{ $class->code }}/missions" class="h-100 p-3 d-flex align-items-center"><i class="fad fa-tasks"></i></a>
        <a href="/classrooms/{{ $class->code }}/store" class="h-100 p-3 d-flex align-items-center"><i class="fad fa-store"></i></a>
        <a href="/classrooms/{{ $class->code }}/rules" class="h-100 p-3 d-flex align-items-center"><i class="fad fa-pencil-ruler"></i></a>
        <a href="/classrooms/{{ $class->code }}/log" class="h-100 p-3 d-flex align-items-center"><i class="fad fa-file-alt"></i></a>
        <a href="/classrooms/{{ $class->code }}/settings" class="h-100 p-3 d-flex align-items-center"><i class="fad fa-sliders-v-square"></i></a>
    </div>
@endsection
