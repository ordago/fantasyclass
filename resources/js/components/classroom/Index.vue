
<template>
  <div class="columns p-2 is-multiline is-variable is-1 mt-0">
    <div
      class="column py-1 is-6-tablet is-12-mobile is-3-desktop is-3-fullhdbox"
    >
      <div class="box w-100 h-100 is-flex has-all-centered">
        <h3 class="w-100 has-text-centered">
          <span v-if="user.is_student == 0 && user.email">
            <a href="/classroom/create" class="is-rounded text-center pointer">
              <i class="fal fa-chalkboard-teacher mr-2"></i>
              {{ trans.get("classroom.add") }}
            </a>
            <hr />
          </span>
          <join-classroom></join-classroom>
        </h3>
      </div>
    </div>

    <div
      v-for="(classroom, index) in orderedClassrooms"
      :key="'classroom-' + index + classroom.id"
      class="
        column
        py-1
        is-6-tablet is-12-mobile is-3-desktop is-3-fullhdbox
        mb-0
        is-flex
        has-all-centered
      "
    >
      <div
        class="
          box
          w-100
          h-100
          d-flex
          is-relative
          rounded
          classroom-round
          text-center
        "
        :style="getStyle(classroom)"
      >
        <h3 class="is-size-4 has-text-light">
          <!-- @if($classroom->pivot->role == 2)
        {!! $icon !!} -->
          <span class="admin">
            <span v-if="classroom.state == 1">
                <i class='far fa-hourglass-end mx-2' v-tippy="{theme: 'light'}" :content='trans.get("classroom.finished")'></i>
            </span>
            <span v-if="classroom.state == 2">
                <i class='far fa-eye-slash mx-2' v-tippy="{theme: 'light'}" :content='trans.get("classroom.disabled")'></i>
            </span>
            <span v-if="classroom.pivot.role == 2">
              <clone-classroom :classroom="classroom"></clone-classroom>
              <a
                :href="'/classroom/' + classroom.code + '/edit'"
                class="has-text-white mx-2"
                v-tippy="{theme: 'light'}"
                :content="trans.get('menu.config')"
                ><i class="far fa-cog"></i
              ></a>
            </span>
            <span
              v-if="classroom.pivot.role == 2"
              v-tippy="{theme: 'light'}"
              :content="trans.get('classroom.admin')"
            >
              <i class="far fa-user-crown"></i>
            </span>
            <span
              v-else-if="classroom.pivot.role == 1"
              v-tippy="{theme: 'light'}"
              :content="trans.get('classroom.teacher')"
            >
              <i class="far fa-user-graduate"></i>
            </span>
            <span v-else v-tippy="{theme: 'light'}" :content="trans.get('classroom.student')">
              <i class="far fa-user"></i>
            </span>
          </span>
          <a :href="getClassIcon(classroom)" class="has-text-light">
            <span v-if="classroom.pivot.role > 0">{{ classroom.name }}</span>
            <span v-else>{{ classroom.adventure_name }}</span>
          </a>
        </h3>
      </div>
    </div>

    <!-- @foreach ($user->classrooms->sortByDesc('updated_at') as $classroom)

  @if($classroom->state == 1)
  @php
  $icon = "<i class='far fa-hourglass-end' v-tippy="{theme: 'light'}" :content='trans.get(\"classroom.finished\")'></i>";
  @endphp
  @elseif($classroom->state == 2)
  @php
  $icon= "<i class='far fa-eye-slash' v-tippy="{theme: 'light'}" :content='trans.get(\"classroom.disabled\")'></i>";
  @endphp
  @else
  @php
  $icon = "";
  @endphp
  @endif
  @php
  $theme = $classroom->theme;
  @endphp -->

    <!-- @section('notifications')
  <notifications :notifications="{{ $notifications ?? '[]' }}" :user="{{ auth()->user() }}" type="both"></notifications>
  @endsection -->

    <!-- @endforeach -->
  </div>
</template>

<script>
// import Utils from "../../utils.js";

export default {
  props: ["user", "classrooms"],
  created() {},
  data: function () {
    return {};
  },
  methods: {
    getClassIcon(classroom) {
      if (classroom.pivot.role > 0) return "/classroom/" + classroom.code;
      else return "/classroom/show/" + classroom.code;
    },
    getStyle(classroom) {
      return (
        "background-image: url('" +
        classroom.background +
        "'); background-size: cover;"
      );
    },
  },
  computed: {
    orderedClassrooms() {
      return _.orderBy(this.classrooms, "updated_at", "desc");
    },
  },
};
</script>