<template>
  <div class="box card-shadow-s mb-0" v-bind:class="getBackground">
    <section class="media">
      <div class="media-content is-relative" style="overflow-y: hidden">
        <div class="content">
          <div class="columns mb-0">
            <div class="column mb-0">
              <h1 class="is-flex is-center-vertically mb-0">
                <i
                  v-if="
                    challengeReactive.is_conquer &&
                    challengeReactive.icon &&
                    !challengeReactive.incomplete
                  "
                  class="is-size-4"
                  :style="'color:' + challengeReactive.color"
                  :class="challengeReactive.icon + ' colored'"
                ></i>
                <i
                  v-if="challengeReactive.type == 1"
                  class="fas fa-users is-size-4 colored"
                ></i>
                {{ challengeReactive.title }}

                <span
                  class="tag is-dark ml-1"
                  v-if="!challengeReactive.incomplete"
                >
                  <span
                    v-if="admin && isHidden"
                    class="mr-2"
                    v-tippy
                    :content="
                      trans.get('challenges.hidden_until') +
                      ' ' +
                      timeLeft(challengeReactive.datetime)
                    "
                  >
                    <i class="fas fa-eye-slash"></i>
                  </span>

                  {{ datetime(challengeReactive.datetime) }}</span
                >
              </h1>
            </div>
            <div class="column is-narrow pr-0" v-if="!admin">
              <div class="is-flex">
                <i
                  v-tippy
                  :content="trans.get('challenges.pinned')"
                  v-if="challengeReactive.pinned == 1"
                  class="
                    py-3
                    px-4
                    mr-2
                    has-background-dark has-text-light
                    rounded
                    fas
                    fa-thumbtack
                  "
                ></i>
                <span
                  class="py-3 px-4 mr-2 rounded"
                  :class="{
                    'has-background-success-light': challengeReactive.completed,
                    'has-background-danger-light': !challengeReactive.completed,
                  }"
                  v-if="!admin && challengeReactive.is_conquer == 1 && full"
                >
                  <span
                    class="has-text-success"
                    v-if="challengeReactive.completed"
                  >
                    <i class="far fa-check"></i>
                  </span>
                  <span class="has-text-danger" v-else>
                    <i class="far fa-times"></i>
                  </span>
                </span>
                <div
                  class="p-3 rounded has-background-light"
                  v-tippy
                  :content="challengeReactive.group.name"
                >
                  <i :class="challengeReactive.group.icon"></i>
                </div>
              </div>
            </div>
            <div class="column is-narrow pr-0" v-else-if="admin && edit">
              <button
                class="button"
                v-tippy
                :content="getMessageDisable()"
                @click="toggleDisabled()"
                :class="{
                  'is-light': challengeReactive.disabled == 0,
                  'is-danger is-light': challengeReactive.disabled == 1,
                }"
              >
                <i
                  class="fas"
                  :class="{
                    'fa-eye-slash': challengeReactive.disabled == 0,
                    'fa-eye': challengeReactive.disabled == 1,
                  }"
                ></i>
              </button>
              <button
                class="button"
                v-tippy
                :content="trans.get('challenges.pin')"
                @click="togglePinned"
                :class="{ 'is-dark': challengeReactive.pinned == 1 }"
              >
                <i class="fas fa-thumbtack"></i>
              </button>
              <span
                v-if="challengeReactive.completion != 4"
                @click="copyPermalink"
                v-tippy
                :content="trans.get('challenges.permalink')"
                class="button custom cursor-pointer"
              >
                <i class="fad fa-link"></i>
                <span class="ml-2 is-hidden-mobile">Permalink</span>
              </span>
              <span
                v-else
                @click="copyChallengeUrl"
                v-tippy
                :content="trans.get('challenges.completion_url_info_1')"
                class="button is-dark custom cursor-pointer"
              >
                <i class="fad fa-link"></i>
                <span class="ml-2 is-hidden-mobile">{{
                  trans.get("challenges.completion_link")
                }}</span>
              </span>
            </div>
          </div>
          <p v-if="challengeReactive.description">
            <small>{{ challengeReactive.description }}</small>
          </p>
          <p
            v-if="challengeReactive.is_conquer && !challengeReactive.incomplete"
          >
            <span>
              <small
                v-if="
                  challengeReactive.xp ||
                  challengeReactive.hp ||
                  challengeReactive.gold ||
                  challengeReactive.cards
                "
                ><i
                  class="
                    fad
                    fa-chevron-up
                    p-1
                    colored
                    has-background-dark has-text-light
                    rounded
                  "
                  :content="trans.get('challenges.attributes')"
                  v-tippy
                ></i
              ></small>
              <small v-if="challengeReactive.xp != 0">
                <i class="fas fa-fist-raised colored"></i>
                {{ challengeReactive.xp }}
                <i class="fal fa-ellipsis-v mx-1"></i>
              </small>
              <small v-if="challengeReactive.hp != 0">
                <i class="fas fa-heart colored"></i>
                {{ challengeReactive.hp }}
                <i class="fal fa-ellipsis-v mx-1"></i>
              </small>
              <small v-if="challengeReactive.gold != 0">
                <i class="fas fa-coins colored"></i>
                {{ challengeReactive.gold }}
                <i class="fal fa-ellipsis-v mx-1"></i>
              </small>
              <small v-if="challengeReactive.cards != 0">
                <i class="fak fa-deck colored"></i>
                {{ challengeReactive.cards }}
                <i class="fal fa-ellipsis-v mx-1"></i>
              </small>
              <small
                v-if="challengeReactive.items && challengeReactive.items.length"
              >
                <i
                  class="
                    fad
                    fa-backpack
                    p-1
                    colored
                    has-background-dark has-text-light
                    rounded
                  "
                  v-tippy
                  :content="trans.get('challenges.items')"
                ></i>
                <img
                  @contextmenu.prevent=""
                  v-for="item in challengeReactive.items"
                  class="mr-1"
                  style="position: relative; top: 4px"
                  :key="item.id"
                  :src="item.src"
                  width="20px"
                />
              </small>
              <small v-if="challengeReactive.objects > 0">
                <i
                  class="
                    fad
                    fa-store
                    p-1
                    colored
                    has-background-dark has-text-light
                    rounded
                  "
                  v-tippy
                  :content="trans.get('challenges.items')"
                ></i>
                {{ challengeReactive.objects }}
              </small>
              <small v-if="challengeReactive.collectionables > 0">
                <i
                  class="
                    fak
                    fa-collection
                    p-1
                    colored
                    has-background-dark has-text-light
                    rounded
                  "
                  v-tippy
                  :content="trans.get('menu.collections')"
                ></i>
                {{ challengeReactive.collectionables }}
                <span v-html="getIcon(challenge.type_collectionable)"></span>
              </small>
            </span>
            <span
              v-if="
                challengeReactive.requirements &&
                challengeReactive.requirements.length &&
                !challengeReactive.incomplete
              "
            >
              <small
                ><i
                  class="
                    fad
                    fa-tasks
                    ml-2
                    p-1
                    colored
                    has-background-dark has-text-light
                    rounded
                  "
                  v-tippy
                  :content="trans.get('challenges.requirements')"
                ></i
              ></small>
              <small v-for="req in challenge.requirements" :key="req.id">
                <img
                  @contextmenu.prevent=""
                  :src="req.src"
                  style="position: relative; top: 4px"
                  :alt="req.alt"
                  width="20px"
                />
              </small>
            </span>
          </p>

          <a
            class="button"
            :href="
              '/classroom/show/' +
              this.code +
              '/challenges/' +
              challengeReactive.permalink
            "
            v-if="!full && !admin"
            >{{ trans.get("challenges.show_challenge") }}</a
          >
          <div
            v-if="edit || full"
            v-html="getContent(challengeReactive.content)"
          ></div>
          <div
            class
            v-for="(question, index) in challenge.questioninfo"
            :key="index"
          >
            <show-question :admin="admin" :question="question"></show-question>
          </div>
          <div class v-for="(question, index) in challenge.stats" :key="index">
            <show-question
              :admin="admin"
              :index="index"
              :question="question"
            ></show-question>
          </div>
          <div class="mt-5" v-if="!challengeReactive.incomplete">
            <div
              class="p-4 m-3 card rounded card-shadow-s"
              :class="{ columns: !attachment.mode == 1 }"
              v-for="(attachment, index) in challenge.attachments"
              :key="attachment.id"
            >
              <div class="column is-narrow">
                <i class="fad fa-globe" v-if="attachment.type == 1"></i>
                <i class="fad fa-icons" v-else-if="attachment.type == 2"></i>
                <i class="fad fa-icons" v-else-if="attachment.type == 8"></i>
                <i
                  class="fad fa-graduation-cap"
                  v-else-if="attachment.type == 3"
                ></i>
                <i
                  class="fab fa-google-drive"
                  v-else-if="attachment.type == 4"
                ></i>
                <i class="fab fa-youtube" v-else-if="attachment.type == 5"></i>
                <i class="fab fa-dropbox" v-else-if="attachment.type == 6"></i>
                <i class="fad fa-file" v-else-if="attachment.type == 7"></i>
                <i
                  class="fad ml-3"
                  v-bind:class="{
                    'fa-link': attachment.mode == 0,
                    'fa-expand': attachment.mode == 1,
                  }"
                ></i>
                <span
                  class="ml-2"
                  v-if="attachment.name && attachment.mode == 1"
                  >{{ attachment.name }}</span
                >
              </div>
              <div class="column" style="word-break: break-all">
                <a
                  target="_blank"
                  v-if="attachment.mode == 0"
                  :href="attachment.url"
                  >{{ attachment.name ? attachment.name : attachment.url }}</a
                >
                <div style="width: 100%" v-if="attachment.mode == 1">
                  <div
                    style="
                      position: relative;
                      padding-bottom: 46.57%;
                      padding-top: 0;
                      height: 0;
                    "
                  >
                    <iframe
                      v-if="attachment.type == 1"
                      :src="attachment.url"
                      width="1090"
                      height="677"
                      style="
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                      "
                      frameborder="0"
                      allowfullscreen="allowfullscreen"
                      allow="geolocation *; microphone *; camera *; midi *; encrypted-media *"
                    ></iframe>
                    <iframe
                      v-if="attachment.type == 8"
                      :src="getHp5(attachment.url)"
                      width="1090"
                      height="677"
                      style="
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                      "
                      frameborder="0"
                      allowfullscreen="allowfullscreen"
                      allow="geolocation *; microphone *; camera *; midi *; encrypted-media *"
                    ></iframe>
                    <!-- <script
                      src="https://h5p.org/sites/all/modules/h5p/library/js/h5p-resizer.js"
                      charset="UTF-8"
                    ></script> -->
                    <iframe
                      v-if="attachment.type == 2"
                      frameborder="0"
                      class="rounded"
                      width="3000px"
                      height="1397px"
                      style="
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                      "
                      :src="
                        attachment.url.slice(0, attachment.url.lastIndexOf('/'))
                      "
                      type="text/html"
                      allowscriptaccess="always"
                      allowfullscreen="true"
                      scrolling="yes"
                      allownetworking="all"
                    ></iframe>

                    <div class="video-wrapper" v-if="attachment.type == 5">
                      <iframe
                        width="560"
                        height="315"
                        :src="
                          'https://youtube.com/embed/' +
                          getYoutube(attachment.url)
                        "
                        frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                      ></iframe>
                    </div>
                  </div>
                </div>
                <!-- <iframe frameborder="0" class="w-100" :src="attachment.url.slice(0, attachment.url.lastIndexOf('/'))" v-if="attachment.mode==1" type="text/html" allowscriptaccess="always" allowfullscreen="true" scrolling="yes" allownetworking="all"></iframe> -->
              </div>
              <div class="column is-narrow" v-if="admin">
                <button
                  class="button is-danger"
                  @click="confirmDelete(attachment.id, index)"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
          <article
            v-if="
              challenge.completion != 0 &&
              !challenge.completed &&
              !admin &&
              full &&
              !challengeReactive.incomplete
            "
            class="message is-warning"
          >
            <div v-html="getMessage(challenge)" class="message-body"></div>
          </article>
          <button
            class="button"
            v-if="!allowComment && (full || edit)"
            @click="allowComment = true"
          >
            <i class="fad fa-comments mr-2"></i>
            {{ trans.get("challenges.comment") }}
          </button>
          <InputEmoji v-if="(edit || full) && allowComment"></InputEmoji>
          <div class="mt-3 comments">
            <div
              class="comment m-0"
              v-for="(comment, index) in orderedComments"
              :key="index"
            >
              <div class="flexCenter imgTeacher">
                <img
                  @contextmenu.prevent=""
                  v-if="comment.info.type == 'student'"
                  width="32px"
                  height="32px"
                  class="rounded"
                  :src="comment.info.avatar"
                />
                <i
                  v-if="comment.info.type == 'teacher'"
                  class="fas fa-user-graduate text-light textshadow"
                ></i>
              </div>
              <div class="commentInfo p-2">
                <div>
                  <span class="tag is-info p-2">{{ comment.info.name }}</span>
                  <span class="tag is-link p-2">{{
                    datetime(comment.info.datetime)
                  }}</span>
                  <button
                    class="button tag is-danger has-text-light p-2"
                    @click="deleteComment(comment.id, index)"
                    v-if="admin"
                  >
                    <i class="far fa-trash-alt"></i>
                  </button>
                </div>
                <div class="flexVertical p-2">{{ clean(comment.text) }}</div>
              </div>
            </div>
            <div class="my-3">
              <a
                class="has-text-dark"
                @click="maxComments = challenge.comments.length"
                v-if="
                  challenge.comments &&
                  challenge.comments.length > 3 &&
                  maxComments != challenge.comments.length
                "
                >{{ trans.get("challenges.load_comments") }}</a
              >
            </div>
          </div>
          <div
            v-if="
              !prevRating &&
              full &&
              !rating &&
              !admin &&
              challengeReactive.is_conquer &&
              !challengeReactive.incomplete
            "
          >
            <div class="mt-4 mb-0">
              <i class="fad fa-bullhorn mr-1 ml-4 mt-2"></i>
              {{ trans.get("challenges.rating_feedback") }}
            </div>
            <VueFeedbackReaction
              containerWidth="50px"
              containerHeight="50px"
              emojiWidth="50px"
              emojiHeight="50px"
              @input="sendRating"
              class="mt-2"
              :labels="['', '', '', '', '']"
              v-model="rating"
            />
          </div>
          <div
            class="mt-2 is-flex is-center-vertically"
            v-if="challengeReactive.rating"
          >
            <vue-reaction-emoji
              :reaction="returnEmoji(challengeReactive.rating)"
              :is-active="true"
              :is-disabled="false"
            />
            Feedback: {{ challengeReactive.rating.toFixed(2) }} / 5
          </div>
          <div class="buttons" v-if="(edit && admin) || !admin">
            <button
              v-if="
                !admin &&
                (challengeReactive.completion == 2 ||
                  challengeReactive.completion == 1) &&
                !checkCompletion &&
                !full &&
                challengeReactive.type == 0 &&
                !challengeReactive.incomplete
              "
              class="button is-info"
              @click="markCompleted"
              :class="{ 'is-loading': $parent.isLoading }"
            >
              <span class="icon is-small">
                <i class="fas fa-check"></i>
              </span>
              <span>{{ trans.get("challenges.mark_title") }}</span>
            </button>
            <div
              v-if="
                !admin &&
                challengeReactive.completion == 3 &&
                !checkCompletion &&
                !full &&
                challengeReactive.type == 0
              "
            >
              <article class="message is-warning">
                <div class="message-body">
                  {{ trans.get("challenges.password_info") }}
                </div>
              </article>
              <div class="field has-addons">
                <div class="control">
                  <input
                    class="input"
                    type="text"
                    v-model="password"
                    :placeholder="trans.get('challenges.password')"
                  />
                </div>
                <div class="control" @click="checkPassword(challenge)">
                  <a class="button is-info" :disabled="!password.length">
                    {{ trans.get("challenges.password_check") }}
                  </a>
                </div>
              </div>
            </div>
            <button
              v-if="admin"
              class="button is-outlined is-link"
              @click="isAttachmentModalActive = true"
            >
              <span class="icon is-small">
                <i class="fas fa-paperclip"></i>
              </span>
              <span>{{ trans.get("challenges.add_attachment") }}</span>
            </button>
            <button
              v-if="admin"
              class="button is-outlined is-primary"
              @click="modal = true"
            >
              <span class="icon is-small">
                <i class="fas fa-question"></i>
              </span>
              <span>{{ trans.get("challenges.add_question") }}</span>
            </button>
            <button
              v-if="admin && challengeReactive.completion != 4"
              class="button is-outlined is-info"
              @click="addToMap"
            >
              <span class="icon is-small">
                <i class="fas fa-map-marker-alt"></i>
              </span>
              <span>{{ trans.get("challenges.add_to_map") }}</span>
            </button>
            <button
              v-if="challengeReactive.is_conquer && admin"
              class="button is-success"
              v-tippy
              :content="trans.get('challenges.mark_tooltip')"
              @click="
                $parent.isLoading = true;
                $parent.showModal(challenge);
              "
              :class="{ 'is-loading': $parent.isLoading }"
            >
              <span class="icon is-small">
                <i class="fas fa-check"></i>
              </span>
              <span>{{ trans.get("challenges.mark") }}</span>
            </button>
            <button
              class="button is-dark is-outlined"
              @click="editChallenge"
              v-if="admin"
            >
              <span class="icon is-small">
                <i class="fas fa-edit"></i>
              </span>
              <span>{{ trans.get("general.edit") }}</span>
            </button>
            <button
              class="button is-danger is-outlined"
              @click="$parent.confirmDelete(challengeReactive.id)"
              v-if="admin"
            >
              <span class="icon is-small">
                <i class="fas fa-trash-alt"></i>
              </span>
              <span>{{ trans.get("general.delete") }}</span>
            </button>
          </div>
        </div>
      </div>
    </section>
    <b-modal
      :active.sync="isAttachmentModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
      v-if="admin"
    >
      <form @submit.prevent="addAttachment">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">
              {{ trans.get("challenges.add_attachment") }}
            </p>
          </header>
          <section class="modal-card-body">
            <b-field>
              <b-select
                :placeholder="trans.get('challenges.attachment_type')"
                icon="paperclip"
                icon-pack="fas"
                v-model="attachment.type"
                required
                style="font-family: Arial, FontAwesome"
              >
                <option value="1" icon="paperclip" icon-pack="fas">
                  Web page
                </option>
                <option value="2">Genial.ly</option>
                <option value="3">Moodle</option>
                <option value="4">Google drive</option>
                <option value="5">Youtube</option>
                <option value="6">Dropbox</option>
                <option value="7">File</option>
                <option value="8">H5p.org</option>
              </b-select>
            </b-field>
            <div
              v-if="
                attachment.type == 1 ||
                attachment.type == 2 ||
                attachment.type == 5 ||
                attachment.type == 8
              "
            >
              <b-radio-button
                v-model="attachment.mode"
                native-value="0"
                type="is-link"
              >
                <b-icon icon="link"></b-icon>
                <span>Link</span>
              </b-radio-button>

              <b-radio-button
                v-model="attachment.mode"
                native-value="1"
                type="is-link"
              >
                <b-icon icon="expand"></b-icon>
                <span>Embedded</span>
              </b-radio-button>
            </div>
            <b-field class="mt-3">
              <b-input
                v-model="attachment.name"
                :placeholder="
                  trans.get('general.name') +
                  ' (' +
                  trans.get('general.optional') +
                  ')'
                "
              ></b-input>
            </b-field>
            <b-field>
              <b-input
                placeholder="URL"
                v-model="attachment.url"
                required
                type="url"
              ></b-input>
            </b-field>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="isAttachmentModalActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
            <button class="button is-primary">
              {{ trans.get("general.add") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>
    <b-modal
      :active.sync="isMarkerModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
      v-if="admin"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">
            {{ trans.get("challenges.add_to_map") }}
          </p>
        </header>
        <section class="modal-card-body">
          <label class="label">{{ trans.get("challenges.map_code") }}</label>
          <textarea
            readonly
            class="textarea"
            v-model="embedCode"
            rows="3"
          ></textarea>
          <button class="button is-success my-1" @click="copyText(embedCode)">
            <i class="fas fa-copy mr-1"></i
            >{{ trans.get("challenges.map_copy_code") }}
          </button>
          <label class="label">{{ trans.get("challenges.map_how_to") }}</label>
          <img
            style="margin-left: 12.5%"
            src="/img/maps/add2gen.gif"
            width="75%"
          />
        </section>
        <footer class="modal-card-foot">
          <button
            class="button"
            type="button"
            @click="isMarkerModalActive = false"
          >
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
    <AddQuestion
      :challenge="challenge.id"
      :modal="modal"
      bank="wc"
      :code="code"
      :challengegroup="challenge.challenges_group_id"
    >
    </AddQuestion>
  </div>
</template>
<script>
import confetti from "canvas-confetti";
import Utils from "../../utils.js";
import AddQuestion from "../questions/AddQuestion.vue";

const InputEmoji = () => import("../utils/InputEmoji.vue");
import { VueReactionEmoji, VueFeedbackReaction } from "vue-feedback-reaction";

export default {
  props: [
    "challenge",
    "edit",
    "admin",
    "code",
    "full",
    "prevRating",
    "students",
  ],
  created: function () {
    this.challengeReactive = this.challenge;
    if (this.challenge.requirements) {
      if (typeof this.challenge.requirements == "string")
        this.challenge.requirements = JSON.parse(this.challenge.requirements);
    }
  },
  data: function () {
    return {
      rating: "",
      password: "",
      challengeReactive: null,
      allowComment: false,
      maxComments: 3,
      isAttachmentModalActive: false,
      isMarkerModalActive: false,
      modal: false,
      embedCode: "",
      attachment: {
        mode: "0",
        type: null,
        name: "",
        url: "",
        challenge_id: null,
      },
      question: {
        challenge_id: null,
        name: "",
        correctAnswer: "",
        incorrectAnswer1: "",
        incorrectAnswer2: "",
        incorrectAnswer3: "",
      },
      comment: "",
    };
  },
  components: {
    InputEmoji,
    VueReactionEmoji,
    VueFeedbackReaction,
    AddQuestion,
  },
  methods: {
    clean(text) {
       text = text.replace("&nbsp;", "");
       text = text.replace("<br>", "");
       return text;
    },
    getMessageDisable() {
      if (this.challengeReactive.disabled)
        return this.trans.get("general.enable");
      return this.trans.get("general.disable");
    },
    toggleDisabled() {
      axios
        .get("/classroom/challenge/disable/" + this.challengeReactive.id)
        .then((response) => {
          this.challengeReactive.disabled
            ? (this.challengeReactive.disabled = 0)
            : (this.challengeReactive.disabled = 1);
          this.$forceUpdate();
        });
    },
    addToMap() {
      axios
        .post("/classroom/challenge/map", {
          challenge: this.challengeReactive.id,
        })
        .then((response) => {
          console.log(response.data);
          this.embedCode = response.data;
          this.isMarkerModalActive = true;
        });
    },
    getIcon(type) {
      switch (type) {
        case 1:
          return '<i class="fas fa-mountains"></i>';
        case 2:
          return '<i class="fas fa-tornado"></i>';
        case 3:
          return '<i class="fas fa-tint"></i>';
        case 4:
          return '<i class="fas fa-fire"></i>';
        default:
          return '<i class="fas fa-random"></i>';
      }
    },
    togglePinned() {
      axios
        .post("/classroom/" + this.code + "/challenges/toggleProp", {
          prop: "pinned",
          id: this.challengeReactive.id,
        })
        .then((response) => {
          this.challengeReactive.pinned =
            this.challengeReactive.pinned == 1 ? 0 : 1;
        });
    },
    getMessage(challenge) {
      let append = this.trans.get("challenges.go_to_challenges_mark");
      if (challenge.completion == 3)
        append = this.trans.get("challenges.go_to_challenges_password");
      return (
        "<i class='fal fa-exclamation-circle'></i> " +
        this.trans.get("challenges.go_to_challenges") +
        " <a href='/classroom/show/" +
        this.code +
        "/section/2'>" +
        this.trans.get("menu.progress") +
        "</a> " +
        append
      );
    },
    copyText(text) {
      navigator.clipboard.writeText(text).then((response) => {
        this.$toast(this.trans.get("success_error.copy_success"), {
          type: "success",
        });
      });
    },
    copyChallengeUrl() {
      axios
        .post("/classroom/challenge/getlink", { challenge: this.challenge.id })
        .then((response) => {
          let url = response.data;
          this.copyText(url);
        });
    },
    copyPermalink() {
      let url =
        window.location.origin +
        "/classroom/show/" +
        this.code +
        "/challenges/" +
        this.challengeReactive.permalink;
      this.copyText(url);
    },
    editChallenge(challenge) {
      axios
        .post("/classroom/" + this.code + "/challenges/info", {
          type: 2,
        })
        .then((response) => {
          this.$parent.students = response.data;
          this.$parent.challengeEdit = this.challenge;
          this.$parent.addChallenge = true;
        });
    },
    returnEmoji(rating) {
      if (rating < 1.8) return "hate";
      else if (rating < 2.5) return "disappointed";
      else if (rating < 3.4) return "natural";
      else if (rating < 4.2) return "good";
      else return "excellent";
    },
    sendRating() {
      axios
        .post("/classroom/challenge/rate", {
          rating: this.rating,
          challenge: this.challenge.id,
        })
        .then((response) => {
          this.challengeReactive.rating = response.data;
          this.$toast(this.trans.get("general.thanks"), { type: "success" });
        });
    },
    getHp5(url) {
      return (
        "https://h5p.org/h5p/embed/" + url.substring(url.lastIndexOf("/") + 1)
      );
    },
    getContent(content) {
      return Utils.replaceSpecial(content);
    },
    deleteComment(id) {
      axios.delete("/classroom/challenge/comment/" + id).then((response) => {
        var index = this.challenge.comments.findIndex(function (comment, i) {
          return comment.id === id;
        });
        this.challenge.comments.splice(index, 1);
        this.$forceUpdate();
      });
    },
    sendComment() {
      this.comment = this.comment.replace("&nbsp;", " ");

      axios
        .post("/classroom/challenge/comment", {
          challenge_id: this.challenge.id,
          text: this.comment,
        })
        .then((response) => {
          this.challenge.comments.push(response.data);
          this.comment = "";
        });
    },
    confirmDelete(id, index) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios
            .delete("/classroom/challenge/attachment/" + id)
            .then((response) => {
              if (response.data === 1) {
                this.challenge.attachments.splice(index, 1);
                this.$forceUpdate();
              }
            });
        },
      });
    },
    getYoutube(url) {
      return Utils.getYoutube(url);
    },
    addQuestion() {
      this.question.challenge_id = this.challenge.id;
      axios
        .post("/classroom/challenge/question", {
          question: this.question,
          type: 1,
        })
        .then((response) => {
          this.modal = false;
          this.$parent.$parent.getChallenges(
            this.challenge.challenges_group_id
          );
        });
    },
    addAttachment() {
      let type = this.attachment.type;
      if (type == 3 || type == 4 || type == 6 || type == 7)
        this.attachment.mode = 0;
      this.attachment.challenge_id = this.challenge.id;
      axios
        .post("/classroom/challenge/attachment", {
          attachment: this.attachment,
        })
        .then((response) => {
          this.isAttachmentModalActive = false;
          this.challenge.attachments.push(response.data);
        });
    },
    datetime(date) {
      return Utils.getDate(date, false);
    },
    timeLeft(date) {
      return Utils.getDateFrom(date, this.trans.locale, false);
    },
    checkPassword() {
      if (this.password)
        axios
          .post("/classroom/" + this.code + "/student/passwordChallenge", {
            challenge: this.challengeReactive.id,
            password: this.password,
          })
          .then((response) => {
            if (
              this.$parent.$parent.$parent.mutableChallenges.length <
              response.data.challenges.length
            ) {
              this.$toast(this.trans.get("challenges.new_challenges"), {
                type: "info",
              });
            }
            this.$parent.$parent.$parent.mutableChallenges =
              response.data.challenges;

            if (response.data.success == true) {
              confetti({
                particleCount: 200,
                spread: 100,
                origin: { y: 1.0 },
              });
              this.challengeReactive.count++;
              this.$parent.$parent.$parent.student.hp = response.data.hp;
              this.$parent.$parent.$parent.student.xp = response.data.xp;
              this.$parent.$parent.$parent.student.gold = response.data.gold;
              this.$parent.$parent.$parent.student.items = response.data.items;
              this.$parent.$parent.$parent.forceReload++;
            } else {
              this.$toast(this.trans.get("challenges.password_error"), {
                type: "error",
              });
            }
          });
    },
    markCompleted() {
      this.$buefy.dialog.confirm({
        title: this.trans.get("challenges.mark_title"),
        message: this.trans.get("challenges.mark_text"),
        confirmText: this.trans.get("challenges.mark_confirm"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-warning",
        iconPack: "fa",
        hasIcon: true,
        onConfirm: () => {
          axios
            .post("/classroom/" + this.code + "/student/markchallenge", {
              challenge: this.challengeReactive.id,
            })
            .then((response) => {
              if (
                this.$parent.$parent.$parent.mutableChallenges.length <
                response.data.challenges.length
              ) {
                this.$toast(this.trans.get("challenges.new_challenges"), {
                  type: "info",
                });
              }
              this.$parent.$parent.$parent.mutableChallenges =
                response.data.challenges;
              if (response.data.success == true) {
                if (response.data.feedback) {
                  this.$buefy.dialog.alert({
                    title: "Feedback! 👏👏",
                    message: Utils.replaceSpecial(response.data.feedback),
                    type: "is-success",
                    ariaRole: "alertdialog",
                    ariaModal: true,
                  });
                }
                confetti({
                  particleCount: 200,
                  spread: 100,
                  origin: { y: 1.0 },
                });
                this.challengeReactive.count++;
                this.$parent.$parent.$parent.student.hp = response.data.hp;
                this.$parent.$parent.$parent.student.xp = response.data.xp;
                this.$parent.$parent.$parent.student.gold = response.data.gold;
                if (response.data.items)
                  this.$parent.$parent.$parent.student.items =
                    response.data.items;
                this.$forceUpdate();
                this.$parent.$parent.$parent.forceReload++;
              }
            });
        },
      });
    },
  },
  computed: {
    orderedComments: function () {
      return _.orderBy(this.challenge.comments, "created_at", "desc").splice(
        0,
        this.maxComments
      );
    },
    checkCompletion() {
      if (
        this.challengeReactive.completion == 1 ||
        this.challengeReactive.completion == 3
      )
        return this.challengeReactive.count == 1;
      if (this.challengeReactive.completion == 2)
        return this.challengeReactive.count == 2;
    },
    isHidden() {
      return moment(this.challengeReactive.datetime).isAfter();
    },
    getBackground() {
      if (this.full) {
        if (this.challengeReactive.incomplete) {
          return "has-background-grey-light	";
        } else if (this.challengeReactive.is_conquer == 1) {
          return "has-background-conquer";
        } else {
          return "has-background-story";
        }
      } else if (this.edit) {
        if (this.isHidden || this.challengeReactive.disabled)
          return "has-background-light";
        return "";
      } else {
        switch (this.challengeReactive.completion) {
          case 0:
          case 1:
          case 3:
          case 4:
            return this.challengeReactive.count === null ? 'has-background-light' : this.challengeReactive.count == 1
              ? "has-background-success-light"
              : "has-background-danger-light";
            break;
          case 2:
            return this.challengeReactive.count == 2
              ? "has-background-success-light"
              : "has-background-danger-light";
            break;
        }
      }
    },
  },
};
</script>
