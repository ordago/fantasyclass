@extends('layouts.app')

@section('content')
<form action="/classroom" method="post">
@csrf


<div class="modal-dialog full-screen modal-lg my-0 mx-3" id="newClassroom">
    <div class="modal-content" style="min-height: calc(100vh - 100px);">
      <div class="modal-header">
        <h5 class="modal-title" id="wizard-title"><i class="fal fa-chalkboard-teacher"></i> Classroom Wizard</h5>
      </div>
      <div class="modal-body grassbg p-3">
        <ul class="nav nav-tabs" id="myTab" tabIndex="2" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#nameAndGoals" role="tab"><i class="fal fa-scroll"></i> {{ __('classroom/create.nameAndGoals') }}</a>
          <li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#cardsPanel" role="tab"><i class="fal fa-award"></i> {{ __('menu.cards') }}</a>
        <li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#levelsPanel" role="tab"><i class="fal fa-trophy"></i> {{ __('menu.levels') }}</a>
        <li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#themePanel" role="tab"><i class="fal fa-palette"></i> {{ __('theme') }}</a>
        <li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#characterPanel" role="tab"><i class="fal fa-mask"></i> {{ __('charTheme') }}</a>
        <li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" data-action="showEnd" href="#infoPanel" role="tab"><i class="fal fa-info"></i> +Info</a>
          <li>
        </ul>
        <div class="tab-content mt-2">
          <div class="tab-pane show active fs-1" id="nameAndGoals" role="tabpanel">
            <h1><i class="fal fa-cog faa-spin animated faa-slow"></i> {{ __('classroom/create.classPrepared') }}</h1>
            <div class="form-group">
              <label for="wizardName">{{ __('classroom/create.name') }} <i class="fas fa-question-circle ml-2" {{ Popper::pop('Tooltip!') }}></i></label>
              <input type="text" name="name" class="form-control form-text" value=""></input>
              @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="adventureName">{{ __('classroom/create.customNameWizard') }} <i class="fas fa-question-circle ml-2" data-toggle='popover' data-placement='top' data-trigger='hover' data-tippy-content=""></i></label>
              <input type="text" class="form-control form-text" name="adventureName" id='adventureName' value=""></input>
              @error('adventureName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
              @enderror
            </div>
            {{ __('classroom/create.goalChange') }}
            <div class="btn-group btn-group-toggle mt-3" data-toggle="buttons" style="width: 100%; overflow-x: auto">
                @foreach ($goals as $goal)
                  <label class="btn btn-secondary">
                      @if ($loop->first)
                        <input type="radio" checked name="nameShowOpt" value="{{ $goal->id }}" autocomplete="off"><i class="{{ $goal->icon }} colored" style="color:{{ $goal->color }}"></i>
                      @else
                        <input type="radio" name="nameShowOpt" value="{{ $goal->id }}" autocomplete="off"><i class="{{ $goal->icon }} colored" style="color:{{ $goal->color }}"></i>
                      @endif
                  </label>
                @endforeach
            </div>
                      </div>
          <div class="tab-pane" id="cardsPanel" role="tabpanel">
            <h4>{{ __('menu.cards') }}</h4>
            <h6 class="mt-3">{{ __('classroom/create.cardsTextWizard') }}</h6>
            <!--<iframe src="utils/cardBank.php" style="width:100%; height: 50vh;"></iframe>-->
          </div>
          <div class="tab-pane" id="levelsPanel" role="tabpanel">
            <h4>{{ __('menu.levels') }}</h4>
            <h6 class="mt-3">{{ __('classroom/create.levelsTextWizard') }} <i class="fas fa-smile-beam colored"></i></h6>
            <!--<iframe src="utils/lvlBank.php" style="width:100%; height: 50vh;"></iframe>-->
          </div>
          <div class="tab-pane" id="themePanel" role="tabpanel">
            <h4>Tema</h4>
            <h6 class="mt-3">{{ __('classroom/create.themeWizard') }}</h6>
            <div class="themes">
                @foreach ($themes as $theme)
                <div class="theme bg_color_theme" style="background-color: {{ $theme->color }}">
                    @if($theme->type == 1)
                        <img src="/img/bg/{{ $theme->name }}"/>
                    @endif
                  </div>
                @endforeach
            </div>
            <br>
          </div>
          <div class="tab-pane" id="characterPanel" role="tabpanel">
            <h1><i class="fal fa-ghost faa-float animated"></i> {{ __('classroom/create.charTheme') }}</h1>
            <!--<img data-id="1" onclick="selectPreview(this)" src="/management/img/character/themes-preview/medieval-fantasy.png" class="themePreview">
            <img data-id="2" onclick="selectPreview(this)" src="/management/img/character/themes-preview/robots.png" class="themePreview" data-toggle='popover' data-placement='top' data-trigger='hover' data-html="true" data-tippy-content="<i class='fab fa-twitter'></i> @ideemaestramari">
            <img data-id="3" onclick="selectPreview(this)" src="/management/img/character/themes-preview/superheros.png" class="themePreview">
            <img data-id="4" onclick="selectPreview(this)" src="/management/img/character/themes-preview/pirateanimals.png" class="themePreview"  data-toggle='popover' data-placement='top' data-trigger='hover' data-html="true" data-tippy-content="<i class='fab fa-twitter'></i> @ideemaestramari">
            <img data-id="0" onclick="selectPreview(this)" src="/management/img/character/themes-preview/custom.png" class="themePreview" data-toggle='popover' data-placement='top' data-trigger='hover' data-html="true" data-tippy-content="">-->
            <?php
            //require_once 'Classroom.php';
            //$class = Classroom::getClassById($_SESSION['active_classroom_id']);
            //$theme = $class->getCharacterTheme();
            ?>

<br>
<div class="alert alert-info">{{ __('classroom/create.charThemeInfo') }}</div>
<br>

</div>
<div class="tab-pane fade" id="infoPanel" role="tabpanel">
  <h1><i class="fal fa-laugh-beam  faa-wrench animated"></i> {{ __('classroom/create.finishTitle') }}</h1>
            <h4 class="mt-3 text-center">{!! __('classroom/create.rememberFinish') !!}</h4>
            <h4 class="text-center">{{ __('classroom/create.infoWizard0') }}</h4>
            <ol class="m-3 mt-4">
              <li class="fs-1 m-2">{{ __('classroom/create.infoWizard1') }} <i class="fal fa-dungeon"></i></li>
              <li class="fs-1 m-2">{{ __('classroom/create.infoWizard2') }} <i class="fal fa-tasks"></i></li>
              <li class="fs-1 m-2">{{ __('classroom/create.infoWizard3') }} <i class="fal fa-users"></i></li>
              <li class="fs-1 m-2">{{ __('classroom/create.infoWizard4') }} <i class="fal fa-hands-helping"></i></li>
              <li class="fs-1 m-2">{{ __('classroom/create.infoWizard5') }} <i class="fal fa-swords"></i></li>
            </ol>
          </div>
        </div>
      </div>

      <div class="modal-footer footerbg">
        <next-step-button text="{{ __('classroom/create.nextStep') }}"></next-step-button>
        <button type="button" type="submit" class="btn btn-success" data-action="endWizard"><i class="fal fa-badge-check faa-vertical animated faa-slow"></i> {{ __('classroom/create.endWizard') }}</button>
      </div>
    </div>
  </div>
</form>
@endsection