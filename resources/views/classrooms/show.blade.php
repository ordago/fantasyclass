@extends('layouts.menu')

@section('content')
<div class="p-2">
  <!-- Utilities -->
  <div class="utilities rounded cardShadowS" id="utilities">
      <div class="tools rounded-left">
        <i class="fal fa-tools"></i>
      </div>
      <span class="link outer_glow" data-action='randomEvent'><i class="fad fa-scroll-old outer_glow" style="font-size:2em;"></i></span>
      <span class="link outer_glow"><i class="fad fa-chart-pie" style="font-size:2em;"></i></span>
      <span class="link outer_glow"><a style="font-size: 2em;" href="utils/attendance.php"><i class="fad fa-calendar-check"></i></a></span>
      <span class="link outer_glow"><i class="fad fa-poll-people" style="font-size: 2em;"></i></span>
      <span class="link outer_glow" ><i class="fad fa-microphone outer_glow" style="font-size:2em;"></i></span>
      <span class="link outer_glow"><i class="fad fa-dice" style="font-size:2em;" onclick="rollTheDice()"></i></span>
      <span class="link outer_glow" data-action='randomStudent'><i class="fad fa-user outer_glow" style="font-size:2em;" ></i></span>
      <span class="link outer_glow" data-action='randomGroup'><i class="fad fa-users outer_glow" style="font-size:2em;"></i></span>
      <span class="link outer_glow" data-action='showClassCode'><i class="fad fa-qrcode outer_glow" style="font-size:2em;"></i></span>
      <span class="link outer_glow" data-action='music'><i class="fad fa-music outer_glow" style="font-size:2em;"></i></span>
      <a href="random.php?class=" target="_blank"><i class="fad fa-random outer_glow" style="font-size:2em;"></i></a>
      <a href="utils/questions.php" class="link outer_glow"><i class="fad fa-question-square" style="font-size:2em;"></i></a>
      <div class="flexCenter floatR">
        <span class="mr-1 hideGrid pointer"><i class="fas fa-th fs-1 colored" style="color:white"></i></span>

        <span><i class="fal fa-sort-numeric-down-alt mr-2"></i></span>
        <span ><i class="fas fa-user coloredGray pointer mr-2" style="color: #eee;" data-action="changeOrder" data-id="0"></i></span>
        <span ><i class="fas fa-heart coloredGray pointer mr-2" data-action="changeOrder" data-id="1"></i></span>
        <span ><i class="fas fa-fist-raised coloredGray pointer mr-2" data-action="changeOrder" data-id="2"></i></span>
        <span ><i class="fas fa-coins coloredGray pointer mr-2" data-action="changeOrder" data-id="3"></i></span>
        <span ><i class="fas fa-gem coloredGray pointer mr-4" data-action="changeOrder" data-id="4"></i></span>
        <span><i class="fal fa-sort-numeric-down-alt mr-2"></i></span>
        <input type="checkbox" id="toggleStdView" class="cbx" style="display:none"/>
        <label  style="width: 40px" for="toggleStdView" class="toggle"><span></span></label>
        <span><i class="fas fa-user ml-2 outer_glow"></i></span>
      </div>
  </div>
  
  <div class="grid grid4g my-2">
    @foreach($class->students as $student)
      <show-student student="{{ json_encode($student) }}"></show-student>
    @endforeach
    <div class="rounded card h-100 d-flex align-items-center text-center">
      <div class="p-4">
        <a href="/classrooms/{{ $class->code }}/students/add">Add students (afegir imatge)</a>
      </div>
    </div>
  </div>

</div>
@endsection