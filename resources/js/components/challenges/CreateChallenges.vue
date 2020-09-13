<template>
  <div class="w-100">
    <form action="#" method="post" @submit.prevent="createChallenge">
      <div class="has-margin-y-3" v-if="edit">
        <label for="name">{{ trans.get('challenges.categories') }}</label>
        <div class="field has-margin-top-3">
          <div class="control">
            <div class="select is-fullwidth">
              <select @input="reload=true" v-model="challenge.challenges_group_id">
                <option
                  v-for="group in challengegroups"
                  :key="group.id"
                  :value="group.id"
                >{{ group.name }}</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="field w-100">
        <label class="label">{{ trans.get('challenges.title') }} *</label>
        <div class="control">
          <input class="input" type="text" v-model="challenge.title" required placeholder />
        </div>
      </div>
      <div class="field w-100">
        <label class="label">{{ trans.get('challenges.description')}}</label>
        <div class="control">
          <input
            class="input"
            v-model="challenge.description"
            type="text"
            :placeholder="trans.get('challenges.description_info')"
          />
        </div>
      </div>
      <!-- <b-field label="Password">
        <b-input
          type="password"
          icon-pack="fas"
          placeholder="Don't abuse of this :D"
          v-model="challenge.password"
          password-reveal
        ></b-input>
      </b-field>-->
      <div class="w-100">
        <b-field :label="trans.get('challenges.avaliability')">
          <b-datetimepicker
            v-model="datepicker"
            :placeholder="trans.get('challenges.click_select')"
            icon-pack="fa"
          >
            <template slot="left">
              <button class="button is-primary" @click="datetime = new Date()">
                <b-icon icon="clock"></b-icon>
                <span>Now</span>
              </button>
            </template>
            <template slot="right">
              <button class="button is-danger" @click="datetime = null">
                <b-icon icon="close"></b-icon>
                <span>Clear</span>
              </button>
            </template>
          </b-datetimepicker>
        </b-field>
      </div>
      <div class="field w-100 has-padding-top-3">
        <label class="label">{{ trans.get('challenges.content') }}</label>
        <div class="control content" data-app>
          <Editor :code="code"></Editor>
        </div>
      </div>
      <div class="field">
        <b-switch
          type="is-info"
          v-model="challenge.is_conquer"
          true-value="1"
          false-value="0"
        >{{ trans.get('challenges.conquer') }}</b-switch>
      </div>
      <div v-if="challenge.is_conquer==1" class="has-padding-4 has-border rounded">
        <div class="field w-100 has-padding-top-3">
          <label class="label">{{ trans.get('challenges.icon') }}</label>
          <div class="field has-addons">
            <p class="control">
              <IconSelector></IconSelector>
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
                style="padding:0;min-width: 50px;"
              />
            </p>
          </div>
          <div class="form-group" style="margin-top: -10px;">
            <label>
              <small>
                {{ trans.get('behaviours.fontawesome') }}
                <a
                  href="https://fontawesome.com/icons?d=gallery"
                  target="_blank"
                >FontAwesome</a>
              </small>
            </label>
          </div>
        </div>
        <label class="label">{{ trans.get('challenges.rewards') }}</label>
        <div class="columns">
          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span class="button is-static">
                  <i class="fas fa-fist-raised colored"></i>
                </span>
              </p>
              <p class="control is-expanded">
                <input type="number" name="xp" class="input" v-model="challenge.xp" required />
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
                <input type="number" name="hp" class="input" v-model="challenge.hp" required />
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
                <input type="number" name="gold" class="input" v-model="challenge.gold" required />
              </p>
            </div>
          </div>

          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span class="button is-static">
                  <i class="fas fa-club colored"></i>
                </span>
              </p>
              <p class="control is-expanded">
                <input type="number" name="cards" class="input" v-model="challenge.cards" required />
              </p>
            </div>
          </div>
        </div>
        <div class="has-margin-top-3" v-if="challenge.type == 0">
          <label for="name">{{ trans.get('challenges.completion') }}</label>
          <div class="field has-margin-top-3">
            <div class="control">
              <div class="select is-fullwidth">
                <select v-model="challenge.completion">
                  <option value="0">{{ trans.get('challenges.completion_teacher') }}</option>
                  <option value="1">{{ trans.get('challenges.completion_student') }}</option>
                  <!-- <option value="2">{{ trans.get('challenges.completion_both') }}</option> -->
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="field has-margin-top-3">
          <b-switch
            type="is-info"
            v-model="challenge.auto_assign"
            true-value="1"
            false-value="0"
            v-if="challenge.cards>0"
          >{{ trans.get('challenges.auto_assign') }}</b-switch>
        </div>
        <div class="field">
          <b-switch
            type="is-info"
            v-model="challenge.type"
            true-value="1"
            false-value="0"
          >{{ trans.get('challenges.group') }}</b-switch>
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
        v-if="!edit"
        class="button is-primary"
      >{{ trans.get('challenges.create_challenge') }}</button>
      <button type="submit" v-else class="button is-info">{{ trans.get('challenges.edit') }}</button>
    </form>
  </div>
</template>
<script>
const Editor = () => import("../utils/Editor.vue");
const IconSelector = () => import("../utils/IconSelector.vue");

export default {
  props: [
    "challengegroup",
    "code",
    "iconPrev",
    "edit",
    "groups",
    "challengegroups",
  ],
  mounted: function () {
    if (this.edit) {
      this.challenge = this.edit;
      this.icon = this.challenge.icon;
      this.content = this.edit.content;
      this.datepicker = new Date(this.edit.datetime);
    } else {
      this.icon = this.iconPrev.icon;
      this.challenge.color = this.iconPrev.color;
      this.datepicker = new Date();
    }
  },
  data: function () {
    return {
      content: ``,
      datepicker: null,
      reload: false,
      icon: null,
      challenge: {
        icon: null,
        color: null,
        datetime: null,
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
        _method: "post",
      },
    };
  },
  methods: {
    createChallenge() {
      this.challenge.content = this.content;
      this.challenge.icon = this.icon;
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
      let route;
      if (this.edit) {
        this.challenge._method = "patch";
        route = "/classroom/" + this.code + "/challenges/" + this.challenge.id;
      } else {
        route = "/classroom/" + this.code + "/challenges";
      }

      axios.post(route, this.challenge).then((response) => {
        this.$toasted.show(response.data.message, {
          position: "top-center",
          duration: 3000,
          iconPack: "fontawesome",
          icon: response.data.icon,
          type: response.data.type,
        });
        if (response.data.type == "success") {
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
    IconSelector,
  },

  computed: {},
};
</script>
