<template>
  <div class="w-100">
    <form action="#" method="post" @submit.prevent="createChallenge">
      <div class="my-3" v-if="edit && !importFlag">
        <label for="name">{{ trans.get("challenges.categories") }}</label>
        <div class="field mt-3">
          <div class="control">
            <div class="select is-fullwidth">
              <select
                @input="reload = true"
                v-model="challenge.challenges_group_id"
              >
                <optgroup
                  v-for="group in challengegroups"
                  :label="group.name"
                  :key="group.id"
                >
                  <option :value="group.id">{{ group.name }}</option>
                  <option
                    v-for="child in group.children"
                    :key="child.id"
                    :value="child.id"
                  >
                    {{ child.name }}
                  </option>
                </optgroup>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="field w-100 mt-2">
        <label class="label">{{ trans.get("challenges.title") }} *</label>
        <div class="control">
          <input
            class="input"
            type="text"
            v-model="challenge.title"
            required
            placeholder
          />
        </div>
      </div>
      <div class="field w-100">
        <label class="label">{{ trans.get("challenges.description") }}</label>
        <div class="control">
          <input
            class="input"
            v-model="challenge.description"
            type="text"
            :placeholder="trans.get('challenges.description_info')"
          />
        </div>
      </div>
      <b-field :label="trans.get('challenges.avaliability')"> </b-field>
      <div class="w-100 buttons mb-2">
        <span v-tippy :content="trans.get('challenges.tz')">
          <b-datetimepicker
            v-model="datepicker"
            locale="es-ES"
            :placeholder="trans.get('challenges.click_select')"
            icon-pack="fa"
            class="button is-rounded"
            style="height: 40px !important"
          >
            <template slot="left">
              <button
                class="button is-primary"
                @click.prevent="datepicker = new Date()"
              >
                <b-icon icon="clock"></b-icon>
                <span>{{ trans.get("general.now") }}</span>
              </button>
            </template>
          </b-datetimepicker>
        </span>
        <button
          @click.prevent="selectStudents"
          class="button is-rounded ml-1"
          v-if="challenge.type == 0"
        >
          <span
            v-if="
              !challenge.students ||
              (challenge.students && challenge.students.length == 0)
            "
          >
            <i class="fas fa-user m-2"></i>
            {{ trans.get("challenges.available_all") }}
          </span>
          <span v-else-if="students && challenge.students">
            <i class="fas fa-user m-2"></i>
            {{ trans.get("challenges.available_some") }}
            {{ students.length - challenge.students.length }}
            {{ trans.get("challenges.available_students") }}
          </span>
        </button>
        <tippy
          interactive
          :animate-fill="false"
          theme="light"
          placement="bottom"
          animation="fade"
          trigger="click"
          style="display: inline-block"
          arrow
        >
          <template v-slot:trigger>
            <button
              @click.prevent=""
              class="button is-rounded"
              :class="{
                'has-background-info-light': challenge.challenge_required,
              }"
              v-html="getChallengeMessage"
            ></button>
          </template>
          <span>
            <p>{{ trans.get("challenges.challenge_hidden") }}</p>
            <section>
              <b-select
                v-model="challenge.challenge_required"
                :placeholder="trans.get('challenges.select_challenge')"
                expanded
              >
                <option :value="null" v-if="challenge.challenge_required">
                  {{ trans.get("challenges.wo_challenge") }}
                </option>
                <optgroup
                  v-for="group in challenges"
                  :label="group.name"
                  :key="group.id"
                >
                  <option
                    v-for="child in group.challenges"
                    :key="child.id"
                    :value="child.id"
                  >
                    {{ child.title }}
                  </option>
                </optgroup>

                <!-- 
                <option v-for="challenge in challenges" :key="challenge.id" :value="challenge.id">{{ challenge.title }}</option> -->
              </b-select>
            </section>
          </span>
        </tippy>
        <tippy
          interactive
          :animate-fill="false"
          theme="light"
          placement="bottom"
          animation="fade"
          trigger="click"
          style="display: inline-block"
          arrow
        >
          <template v-slot:trigger>
            <button
              @click.prevent=""
              class="button is-rounded ml-1"
              :class="{
                'has-background-info-light':
                  challenge.requirements && challenge.requirements.length,
              }"
              v-html="getItemMessage"
            ></button>
          </template>
          <span>
            <p>{{ trans.get("challenges.challenge_hidden_object") }}</p>
            <section>
              <vue-select-image
                :dataImages="items"
                @onselectmultipleimage="onSelectMultipleImageRequirements"
                :is-multiple="true"
                :selectedImages="challenge.requirements"
                w="30px"
              >
              </vue-select-image>
            </section>
          </span>
        </tippy>
      </div>
      <div class="field w-100 pt-1">
        <label class="label">{{ trans.get("challenges.content") }}</label>
        <div class="control content" data-app>
          <Editor
            v-model="content"
            v-if="editor"
            height="70vh"
            :code="code"
          ></Editor>
        </div>
      </div>
      <div class="field">
        <b-switch
          type="is-info"
          v-model="challenge.is_conquer"
          true-value="1"
          false-value="0"
          >{{ trans.get("challenges.conquer") }}</b-switch
        >
      </div>
      <div v-if="challenge.is_conquer == 1" class="p-4 has-border rounded">
        <div class="control content" data-app>
          <label class="label" for="name">{{
            trans.get("challenges.max_date")
          }}</label>
          <span>
            <b-datetimepicker
              :first-day-of-week="1"
              v-model="datepickerEnd"
              locale="es-ES"
              :placeholder="trans.get('challenges.click_select')"
              icon-pack="fa"
              position="is-top-right"
              class="button is-rounded mr-2"
              style="height: 40px !important"
            >
              <template slot="left">
                <button
                  class="button is-primary"
                  @click.prevent="datepickerEnd = new Date()"
                >
                  <b-icon icon="clock"></b-icon>
                  <span>{{ trans.get("general.now") }}</span>
                </button>
              </template>
              <template slot="right">
                <button
                  class="button is-danger"
                  @click.prevent="datepickerEnd = null"
                >
                  <b-icon icon="times"></b-icon>
                  <span>{{ trans.get("general.delete") }}</span>
                </button>
              </template>
            </b-datetimepicker>
          </span>
        </div>
        <div class="field">
          <b-switch
            type="is-info"
            v-model="challenge.type"
            true-value="1"
            false-value="0"
            >{{ trans.get("challenges.group") }}</b-switch
          >
        </div>
        <div class="field w-100 pt-3">
          <label class="label">{{ trans.get("challenges.icon") }}</label>
          <div class="field has-addons">
            <p class="control">
              <IconSelectorPro v-model="icon"></IconSelectorPro>
            </p>
            <p class="control is-expanded">
              <input
                v-model="icon"
                ref="icon"
                name="icon"
                class="input"
                required
                :placeholder="trans.get('behaviours.icon_select')"
                type="text"
              />
            </p>
            <p class="control">
              <input
                v-model="challenge.color"
                name="color"
                class="input"
                type="color"
                style="padding: 0; min-width: 50px"
              />
            </p>
          </div>
          <div class="form-group" style="margin-top: -10px">
            <label>
              <small>
                {{ trans.get("behaviours.fontawesome") }}
                <a
                  href="https://fontawesome.com/icons?d=gallery"
                  target="_blank"
                  >FontAwesome</a
                >
              </small>
            </label>
          </div>
        </div>
        <label class="label">{{ trans.get("challenges.rewards") }}</label>
        <div class="columns">
          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span class="button is-static">
                  <i class="fas fa-fist-raised colored"></i>
                </span>
              </p>
              <p class="control is-expanded">
                <input
                  type="number"
                  name="xp"
                  class="input"
                  v-model="challenge.xp"
                  required
                />
              </p>
            </div>
          </div>
          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span class="button is-static">
                  <i class="fas fa-heart colored"></i>
                </span>
              </p>
              <p class="control is-expanded">
                <input
                  type="number"
                  name="hp"
                  class="input"
                  v-model="challenge.hp"
                  required
                />
              </p>
            </div>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span class="button is-static">
                  <i class="fas fa-coins colored"></i>
                </span>
              </p>
              <p class="control is-expanded">
                <input
                  type="number"
                  name="gold"
                  class="input"
                  v-model="challenge.gold"
                  required
                />
              </p>
            </div>
          </div>

          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span class="button is-static">
                  <i class="fak fa-deck colored"></i>
                </span>
              </p>
              <p class="control is-expanded">
                <input
                  type="number"
                  name="cards"
                  class="input"
                  v-model="challenge.cards"
                  required
                />
              </p>
            </div>
          </div>
        </div>
        <div class="field mt-3">
          <b-switch
            type="is-info"
            v-model="challenge.auto_assign"
            true-value="1"
            false-value="0"
            v-if="challenge.cards > 0"
            >{{ trans.get("challenges.auto_assign") }}</b-switch
          >
        </div>
        <label class="label">{{ trans.get("challenges.reward_items") }}</label>

        <vue-select-image
          :dataImages="items"
          @onselectmultipleimage="onSelectMultipleImage"
          :is-multiple="true"
          :selectedImages="challenge.items"
          w="30px"
        >
        </vue-select-image>

        <label class="label">{{
          trans.get("challenges.assign_objects")
        }}</label>

        <div class="field has-addons">
          <p class="control">
            <span class="button is-static">
              <i class="fas fa-store colored" style="color: red"></i>
            </span>
          </p>
          <p class="control is-expanded">
            <input
              type="number"
              name="objects"
              class="input"
              v-model="challenge.objects"
              required
            />
          </p>
        </div>
        <div v-if="collections && collections.length">
          <label class="label">{{
            trans.get("challenges.assign_collectionables")
          }}</label>
          <div class="field has-addons">
            <p class="control">
              <span class="button is-static">
                <i class="fak fa-collection colored" style="color: white"></i>
              </span>
            </p>
            <p class="control is-expanded">
              <input
                type="number"
                name="objects"
                class="input"
                min="0"
                v-model="challenge.collectionables"
                required
              />
            </p>
          </div>
          <div v-if="challenge.collectionables > 0" class="px-3 py-2">
            <label class="label">{{
              trans.get("challenges.collection")
            }}</label>
            <div class="control">
              <div class="select is-fullwidth">
                <select v-model="challenge.collection_id">
                  <option value="0">
                    {{ trans.get("challenges.random_collection") }}
                  </option>
                  <option
                    :value="collection.id"
                    v-for="collection in collections"
                    :key="'collection-' + collection.id"
                  >
                    {{ collection.name }}
                  </option>
                </select>
              </div>
            </div>
            <label class="label mt-2">{{
              trans.get("challenges.collection_type")
            }}</label>
            <div class="control">
              <div class="select is-fullwidth">
                <select v-model="challenge.type_collectionable">
                  <option value="0" selected>
                    {{ trans.get("challenges.without_type") }}
                  </option>
                  <option value="1">
                    {{ trans.get("collections.earth") }}
                  </option>
                  <option value="2">
                    {{ trans.get("collections.wind") }}
                  </option>
                  <option value="3">
                    {{ trans.get("collections.water") }}
                  </option>
                  <option value="4">
                    {{ trans.get("collections.fire") }}
                  </option>
                  <!-- <option value="2">{{ trans.get('challenges.completion_both') }}</option> -->
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-3" v-if="challenge.type == 0">
          <label class="label" for="name">{{
            trans.get("challenges.completion")
          }}</label>
          <div class="field mt-3">
            <div class="control">
              <div class="select is-fullwidth">
                <select v-model="challenge.completion">
                  <option value="0">
                    {{ trans.get("challenges.completion_teacher") }}
                  </option>
                  <option value="1">
                    {{ trans.get("challenges.completion_student") }}
                  </option>
                  <option value="3">
                    {{ trans.get("challenges.completion_password") }}
                  </option>
                  <option value="4">
                    {{ trans.get("challenges.completion_url") }}
                  </option>
                  <!-- <option value="2">{{ trans.get('challenges.completion_both') }}</option> -->
                </select>
              </div>
            </div>
          </div>

          <div
            class="control content"
            data-app
          >
            <label class="label" for="name">Feedback</label>
            <Editor
              v-if="editor"
              v-model="feedback"
              height="200px"
              :code="code"
            ></Editor>
          </div>
          <b-field
            :label="trans.get('challenges.password')"
            class="pl-3 mt-2"
            v-if="challenge.completion == 3"
          >
            <b-input
              type="password"
              icon-pack="fas"
              placeholder=""
              required
              v-model="challenge.password"
              password-reveal
            ></b-input>
          </b-field>

          <article v-if="challenge.completion == 4" class="message is-warning">
            <div class="message-body">
              <p>{{ trans.get("challenges.completion_url_info_1") }}</p>
              <p class="mt-2">
                <strong>{{
                  trans.get("challenges.completion_url_info_2")
                }}</strong>
              </p>
            </div>
          </article>
        </div>

        <!-- <div class="field">
          <b-switch
            type="is-info"
            v-model="challenge.optional"
            true-value="1"
            false-value="0"
          >{{ trans.get('challenges.optional') }}</b-switch>
        </div>-->
      </div>
      <button
        type="submit"
        v-if="!edit || importFlag"
        class="button is-primary"
      >
        {{ trans.get("challenges.create_challenge") }}
      </button>
      <button type="submit" v-else class="button is-primary">
        <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
      </button>
    </form>
    <b-modal :active.sync="isModalActive" width="95%" scroll="keep">
      <div class="p-5 rounded has-background-light">
        <button class="button is-info" @click="disableAll">
          <i class="fas fa-eraser mr-2"></i>
          {{ trans.get("utils.remove_selection") }}
        </button>
        <div v-for="student in students" class="p-3" :key="student.id">
          <div class="columns">
            <div class="column is-narrow is-flex has-all-centered">
              <div class="field">
                <b-switch
                  :value="getVisibility(student.id)"
                  true-value="1"
                  false-value="0"
                  @input="toggleVisibility(student.id)"
                  type="is-info"
                  >{{ student.name }}</b-switch
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
  </div>
</template>
<script>
const Editor = () => import("../utils/Editor.vue");
const IconSelectorPro = () => import("../utils/IconSelectorPro.vue");

import VueSelectImage from "vue-select-image";
require("vue-select-image/dist/vue-select-image.css");

export default {
  props: [
    "challengegroup",
    "code",
    "iconPrev",
    "edit",
    "importFlag",
    "groups",
    "challengegroups",
    "studentsLoaded",
  ],
  created: function () {
    if (this.edit) {
      this.challenge = this.edit;
      if (this.challenge.requirements) {
        if (typeof this.challenge.requirements == "string")
          this.challenge.requirements = JSON.parse(this.challenge.requirements);
      }
      if (this.challenge.items) {
        if (typeof this.challenge.items == "string")
          this.challenge.items = JSON.parse(this.challenge.items);
      }
    }
  },
  mounted: function () {
    this.getAllChallenges();
    this.editor = false;
    if (this.edit) {
      if (this.studentsLoaded) this.students = this.studentsLoaded;

      if (this.challenge.students) {
        if (typeof this.challenge.students == "string")
          this.challenge.students = JSON.parse(this.challenge.students);
      }

      if (this.challenge.students == null) this.challenge.students = [];

      this.content = this.edit.content;
      this.icon = this.challenge.icon;
      this.datepicker = new Date(this.edit.datetime);
      if (this.edit.dateend) this.datepickerEnd = new Date(this.edit.dateend);
      this.feedback = this.edit.feedback;
    } else {
      this.icon = this.iconPrev.icon;
      this.challenge.color = this.iconPrev.color;
      this.datepicker = new Date();
    }
    this.editor = true;
    this.$forceUpdate();
  },
  data: function () {
    return {
      challenges: false,
      items: [],
      editor: false,
      datepicker: null,
      datepickerEnd: null,
      reload: false,
      icon: null,
      isModalActive: false,
      students: null,
      content: ``,
      feedback: ``,
      collections: [],
      challenge: {
        icon: null,
        color: null,
        datetime: null,
        datetend: null,
        description: null,
        title: null,
        content: ``,
        is_conquer: 0,
        completion: 0,
        xp: 0,
        hp: 0,
        gold: 0,
        cards: 0,
        auto_assign: 0,
        optional: 0,
        type: 0,
        password: null,
        challenges_group_id: null,
        students: [],
        items: [],
        requirements: [],
        _method: "post",
        challenge_required: null,
        objects: 0,
        collectionables: 0,
        collection_id: null,
        type_collectionable: 0,
      },
    };
  },
  methods: {
    onSelectMultipleImageRequirements(items) {
      this.challenge.requirements = items;
    },
    onSelectMultipleImage(items) {
      this.challenge.items = items;
    },
    getAllChallenges() {
      axios
        .get("/classroom/" + this.code + "/challenges/all")
        .then((response) => {
          this.challenges = response.data.challenges;

          this.items = response.data.items.map(function (row) {
            return { id: row.id, src: row.icon, alt: row.description };
          });

          this.collections = response.data.collections;
          if (this.collections.length) this.challenge.collection_id = 0;
        });
    },
    disableAll() {
      this.challenge.students = [];
      this.students.forEach((student) => {
        this.challenge.students.push(student.id);
      });
    },
    getVisibility(id) {
      return this.challenge.students.indexOf(id) === -1 ? 1 : 0;
    },
    toggleVisibility(id) {
      var index = this.challenge.students.indexOf(id);
      if (index === -1) {
        this.challenge.students.push(id);
      } else {
        this.challenge.students.splice(index, 1);
      }
    },
    selectStudents() {
      axios
        .post("/classroom/" + this.code + "/challenges/info", {
          type: 2,
        })
        .then((response) => {
          this.students = response.data.students;
          this.isModalActive = true;
        });
    },
    createChallenge() {
      this.challenge.content = this.content;
      this.challenge.icon = this.icon;
      this.challenge.feedback = this.feedback;
      if (!this.challenge.challenges_group_id)
        this.challenge.challenges_group_id = this.challengegroup;
      let date = this.datepicker;
      this.challenge.datetime =
        date.getFullYear() +
        "-" +
        (date.getMonth() + 1) +
        "-" +
        date.getDate() +
        " " +
        date.getHours() +
        ":" +
        date.getMinutes();
      date = this.datepickerEnd;
      if (date)
        this.challenge.dateend =
          date.getFullYear() +
          "-" +
          (date.getMonth() + 1) +
          "-" +
          date.getDate() +
          " " +
          date.getHours() +
          ":" +
          date.getMinutes();
      else this.challenge.dateend = null;
      let route;
      if (this.edit && !this.importFlag) {
        this.challenge._method = "patch";
        route = "/classroom/" + this.code + "/challenges/" + this.challenge.id;
      } else {
        route = "/classroom/" + this.code + "/challenges";
      }

      if (this.challenge.type == 1) this.challenge.completion = 0;

      axios.post(route, this.challenge).then((response) => {
        this.$toast(response.data.message, { type: response.data.type });
        if (response.data.type == "success") {
          this.importFlag = false;
          this.$parent.addChallenge = false;
          this.$parent.$parent.getChallenges(
            this.challenge.challenges_group_id
          );
        }
      });
      if (this.reload) location.reload(true);
      else this.$parent.$parent.$forceUpdate();
    },
    dateFormatter(dt) {
      return dt.toLocaleDateString("es-ES", dateoptions);
    },
  },
  components: {
    Editor,
    IconSelectorPro,
    VueSelectImage,
  },

  computed: {
    getItemMessage() {
      if (this.challenge.requirements && this.challenge.requirements.length) {
        return this.trans.get("challenges.exist_requirement_item");
      }
      return this.trans.get("challenges.mark_requirement_item");
    },
    getChallengeMessage() {
      if (!this.challenge.challenge_required) {
        return this.trans.get("challenges.mark_prev_challenge");
      }
      return this.trans.get("challenges.exist_requirement");
    },
  },
};
</script>
<style>
.button .input {
  border: none !important;
  text-align: center;
  background-color: transparent;
}
</style>