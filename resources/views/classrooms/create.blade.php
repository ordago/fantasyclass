@extends('layouts.app')

@section('content')
<form action="/classroom" method="post">
@csrf

<div class="modal-dialog full-screen  modal-lg my-3 pt-3 mx-3" id="newClassroom">
    <div class="modal-content " style="min-height: calc(100vh - 95px);">
      <div class="card-header p-0 pt-3 border-0">
        <ul class="nav nav-tabs" id="myTab" tabIndex="2" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#nameAndGoals" role="tab"><i class="fal fa-scroll"></i> {{ __('classroom.name_and_goals') }}</a>
          <li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#levelsPanel" role="tab"><i class="fal fa-trophy"></i> {{ __('menu.levels') }}</a>
        <li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#themePanel" role="tab"><i class="fal fa-palette"></i> {{ __('classroom.theme') }}</a>
        <li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#characterPanel" role="tab"><i class="fal fa-mask"></i> {{ __('classroom.char_theme') }}</a>
        <li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" data-action="showEnd" href="#infoPanel" role="tab"><i class="fal fa-info"></i> +Info</a>
          <li>
        </ul>
      </div>
        <div class="tab-content mt-2 card-body wizard">
          <div class="tab-pane show active fs-1" id="nameAndGoals" role="tabpanel">
            <h1><i class="fal fa-cog faa-spin animated faa-slow"></i> {{ __('classroom.prepare') }}</h1>
            <div class="form-group">
              <label for="wizardName">{!! __('classroom.wizard_name') !!}</label>
              <input type="text" name="name" value="{{ old('name') }}" class="form-control form-text  @error('name') is-invalid @enderror" value=""></input>

              @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="adventureName">{!! __('classroom.adventure_name') !!}</label>
              <input type="text" value="{{ old('adventureName') ? old('adventureName') : 'FantasyClass' }}" class="form-control form-text @error('adventureName') is-invalid @enderror" name="adventureName" id='adventureName' value=""></input>
              @error('adventureName')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @endif
            </div>
            {!! __('classroom.goal_type') !!}
            <div class="btn-group btn-group-toggle mt-3" data-toggle="buttons" style="width: 100%; overflow-x: auto">
                @foreach ($goals as $goal)
                  <label class="btn btn-secondary">
                      @if ($loop->first)
                        <input type="radio" name="goalType"  value="{{ $goal->id }}" @if(!old('goalType') or old('goalType') == $goal->id) checked @endif autocomplete="off"><i class="{{ $goal->icon }} colored" style="color:{{ $goal->color }}"></i>
                      @else
                        <input type="radio" name="goalType" @if(old('goalType') == $goal->id) checked @endif value="{{ $goal->id }}" autocomplete="off"><i class="{{ $goal->icon }} colored" style="color:{{ $goal->color }}"></i>
                      @endif
                  </label>
                @endforeach
            </div>
          </div>
          <div class="tab-pane" id="levelsPanel" role="tabpanel">
            <h4>{{ __('menu.levels') }}</h4>
            <h6 class="mt-3">{{ __('classroom.levels_text') }} <i class="fas fa-smile-beam colored"></i></h6>
            <h1 class="bg-danger">WIP. First create levels</h1>
            <!--<iframe src="utils/lvlBank.php" style="width:100%; height: 50vh;"></iframe>-->
          </div>
          <div class="tab-pane" id="themePanel" role="tabpanel">
            <h4>{{ __('classroom.theme') }}</h4>
            <h6 class="mt-3">{{ __('classroom.theme_text') }}</h6>
            <div class="themes">
                @foreach ($themes as $theme)

                <label>
                    @if ($loop->first)
                      <input type="radio" name="bgtheme" title="i'm the first" value="{{ $theme->id }}" @if(!old('bgtheme')) checked @endif {{ (old('bgtheme') == "$theme->id") ? "checked" : "" }} checked>
                    @else
                      <input type="radio" name="bgtheme" value="{{ $theme->id }}" {{ (old('bgtheme') && old('bgtheme') == "$theme->id") ? "checked" : "" }}>
                    @endif
                    <div class="theme bg_color_theme" style="background-color: {{ $theme->color }}">
                      @if($theme->type == 1)
                          <img src="/img/bg/{{ $theme->name }}"/>
                      @else 
                          <img src="/img/bg/empty.png"/>
                      @endif
                  </div>
                </label>                  
                @endforeach
            </div>
            <br>
          </div>
          <div class="tab-pane" id="characterPanel" role="tabpanel">
            <h1><i class="fal fa-ghost faa-float animated"></i> {{ __('classroom.char_theme') }}</h1>
              <label>
                <input type="radio" name="charTheme" value="1" @if(!old('charTheme')) checked @endif {{ (old('charTheme') == "1") ? "checked" : "" }}>
                <img src="/img/character/themes-preview/medieval-fantasy.png" class="themePreview">
              </label>
              <label>
                <input type="radio" name="charTheme" value="2" {{ (old('charTheme') == "2") ? "checked" : "" }}>
                <img src="/img/character/themes-preview/robots.png" class="themePreview" v-tippy="{interactive: true}" content="<a class='text-light' href='https://twitter.com/ideemaestramari'><i class='fab fa-twitter'></i> @ideemaestramari</a>">
              </label>
              <label>
                <input type="radio" name="charTheme" value="3" {{ (old('charTheme') == "3") ? "checked" : "" }}>
                <img src="/img/character/themes-preview/superheros.png" class="themePreview">
              </label>
              <label>
                <input type="radio" name="charTheme" value="4" {{ (old('charTheme') == "4") ? "checked" : "" }}>
                <img src="/img/character/themes-preview/pirateanimals.png" class="themePreview" v-tippy="{interactive: true}" content="<a class='text-light' href='https://twitter.com/ideemaestramari'><i class='fab fa-twitter'></i> @ideemaestramari</a>">
              </label>
              <label>
                <input type="radio" name="charTheme" value="0" {{ (old('charTheme') == "0") ? "checked" : "" }}>
                <img src="/img/character/themes-preview/custom.png" class="themePreview" v-tippy content="{{ __('classroom.custom_theme') }}">
              </label>
<br>
<div class="alert alert-info">{{ __('classroom.char_theme_info') }}</div>
<br>

</div>
<div class="tab-pane fade" id="infoPanel" role="tabpanel">
  <h1 class="mb-0"><i class="fal fa-laugh-beam  faa-wrench animated"></i> {{ __('classroom.finish_title') }}</h1>
            <h4 class="text-center">{{ __('classroom.info_wizard_0') }}</h4>
            <ol class="m-3 mt-4">
              <li class="fs-1 m-2">{{ __('classroom.info_wizard_1') }} <i class="fal fa-users"></i></li>
              <li class="fs-1 m-2">{{ __('classroom.info_wizard_2') }} <i class="fal fa-tasks"></i></li>
              <li class="fs-1 m-2">{{ __('classroom.info_wizard_3') }} <i class="fal fa-treasure-chest"></i></li>
              <li class="fs-1 m-2">{{ __('classroom.info_wizard_4') }} <i class="fal fa-hands-helping"></i></li>
              <li class="fs-1 m-2">{{ __('classroom.info_wizard_5') }} <i class="fal fa-swords"></i></li>
            </ol>
          </div>
        </div>
      <div class="modal-footer footerbg">
        <button type="submit" class="btn btn-success"><i class="fal fa-badge-check faa-vertical animated faa-slow"></i> {{ __('classroom.end_wizard') }}</button>
      </div>
    </div>
  </div>
</form>
@endsection