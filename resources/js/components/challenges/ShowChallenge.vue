<template>
  <div class="box has-margin-bottom-3" v-bind:class="getBackground">
    <section class="media">
      <div class="media-content">
        <div class="content">
          <h1>
            <i
              v-if="challengeReactive.is_conquer && challengeReactive.icon"
              class="is-size-4"
              :style="'color:' + challengeReactive.color"
              :class="challengeReactive.icon + ' colored'"
            ></i>
            <i v-if="challengeReactive.type==1" class="fas fa-users is-size-4 colored"></i>
            {{ challengeReactive.title }}
            <span
              class="tag is-light"
            >{{ challengeReactive.datetime }}</span>
          </h1>
          <p>
            <small>{{ challengeReactive.description }}</small>
          </p>
          <p v-if="challengeReactive.is_conquer">
            <small v-if="challengeReactive.xp!=0">
              <i class="fas fa-fist-raised colored"></i>
              {{ challengeReactive.xp }}
            </small>
            <small v-if="challengeReactive.hp!=0">
              <i class="fas fa-heart colored"></i>
              {{ challengeReactive.hp }}
            </small>
            <small v-if="challengeReactive.gold!=0">
              <i class="fas fa-coins colored"></i>
              {{ challengeReactive.gold }}
            </small>
            <small v-if="challengeReactive.cards!=0">
              <i class="fas fa-club colored"></i>
              {{ challengeReactive.cards }}
            </small>
          </p>
          <!-- class="el-tiptap-editor__content" -->
          <div v-if="edit || full" v-html="challengeReactive.content"></div>
          <div class="has-margin-top-5">
            <div
              class="columns has-padding-4 has-margin-3 card rounded card-shadow-s"
              v-for="(attachment, index) in challenge.attachments"
              :key="attachment.id"
            >
              <div class="column is-narrow">
                <i class="fad fa-globe" v-if="attachment.type == 1"></i>
                <i class="fad fa-icons" v-else-if="attachment.type == 2"></i>
                <i class="fad fa-graduation-cap" v-else-if="attachment.type == 3"></i>
                <i class="fab fa-google-drive" v-else-if="attachment.type == 4"></i>
                <i class="fab fa-youtube" v-else-if="attachment.type == 5"></i>
                <i class="fab fa-dropbox" v-else-if="attachment.type == 6"></i>
                <i class="fad fa-file" v-else-if="attachment.type == 7"></i>
                <i
                  class="fad has-margin-left-3"
                  v-bind:class="{ 'fa-link' : attachment.mode == 0, 'fa-expand' : attachment.mode == 1 }"
                ></i>
              </div>
              <div class="column" style="word-break: break-all;">
                <a
                  target="_blank"
                  v-if="attachment.mode == 0"
                  :href="attachment.url"
                >{{ attachment.name ? attachment.name : attachment.url }}</a>
                <div style="width: 100%;" v-if="attachment.mode==1">
                  <div
                    style="position: relative; padding-bottom: 46.57%; padding-top: 0; height: 0;"
                  >
                    <iframe
                      v-if="attachment.type == 2"
                      frameborder="0"
                      class="rounded"
                      width="3000px"
                      height="1397px"
                      style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                      :src="attachment.url.slice(0, attachment.url.lastIndexOf('/'))"
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
                        :src="'https://youtube.com/embed/' + getYoutube(attachment.url)"
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
                <button class="button is-danger" @click="confirmDelete(attachment.id, index)">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="has-padding-3 has-text-right" v-if="edit && admin || !admin">
            <button
              v-if="!admin && (challengeReactive.completion == 2 ||challengeReactive.completion == 1) && !checkCompletion"
              class="button is-info"
              @click="markCompleted(challenge)"
            >
              <span class="icon is-small">
                <i class="fas fa-check"></i>
              </span>
              <span>Mark as realised</span>
            </button>
            <button
              v-if="admin"
              class="button is-outlined is-link"
              @click="isAttachmentModalActive=true"
            >
              <span class="icon is-small">
                <i class="fas fa-paperclip"></i>
              </span>
              <span>Add attachment</span>
            </button>
            <button
              v-if="challengeReactive.is_conquer && admin"
              class="button is-success is-outlined"
              @click="$parent.showModal(challenge)"
            >
              <span class="icon is-small">
                <i class="fas fa-check"></i>
              </span>
              <span>Mark</span>
            </button>
            <button
              class="button is-dark is-outlined"
              @click="$parent.challengeEdit=challenge;$parent.addChallenge=true"
              v-if="admin"
            >
              <span class="icon is-small">
                <i class="fas fa-edit"></i>
              </span>
              <span>Edit</span>
            </button>
            <button
              class="button is-danger is-outlined"
              @click="$parent.confirmDelete(challengeReactive.id)"
              v-if="admin"
            >
              <span class="icon is-small">
                <i class="fas fa-trash-alt"></i>
              </span>
              <span>Delete</span>
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
            <p class="modal-card-title">Add attachment</p>
          </header>
          <section class="modal-card-body">
            <b-field>
              <b-select
                placeholder="Attachment type"
                icon="paperclip"
                icon-pack="fas"
                v-model="attachment.type"
                required
                style="font-family:Arial, FontAwesome;"
              >
                <option value="1" icon="paperclip" icon-pack="fas">Web page</option>
                <option value="2">Genial.ly</option>
                <option value="3">Moodle</option>
                <option value="4">Google drive</option>
                <option value="5">Youtube</option>
                <option value="6">Dropbox</option>
                <option value="7">File</option>
              </b-select>
            </b-field>
            <div v-if="attachment.type == 1 || attachment.type == 2 || attachment.type == 5">
              <b-radio-button v-model="attachment.mode" native-value="0" type="is-link">
                <b-icon icon="link"></b-icon>
                <span>Link</span>
              </b-radio-button>

              <b-radio-button v-model="attachment.mode" native-value="1" type="is-link">
                <b-icon icon="expand"></b-icon>
                <span>Embedded</span>
              </b-radio-button>
            </div>
            <b-field>
              <b-input v-model="attachment.name" placeholder="Name (Optional)"></b-input>
            </b-field>
            <b-field>
              <b-input placeholder="URL" v-model="attachment.url" required type="url"></b-input>
            </b-field>
          </section>
          <footer class="modal-card-foot">
            <button class="button" type="button" @click="isAttachmentModalActive=false">Close</button>
            <button class="button is-primary">Add</button>
          </footer>
        </div>
      </form>
    </b-modal>
  </div>
</template>
<script>
import confetti from "canvas-confetti";
import Utils from "../../utils.js";

export default {
  props: ["challenge", "edit", "admin", "code", "full"],
  created: function() {
    this.challengeReactive = this.challenge;
  },
  data: function() {
    return {
      challengeReactive: null,
      isAttachmentModalActive: false,
      attachment: {
        mode: "0",
        type: null,
        name: "",
        url: "",
        challenge_id: null
      }
    };
  },
  methods: {
    confirmDelete(id, index) {
          this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios.delete("/classroom/challenge/attachment/" + id).then(response => {
            console.log(response.data)
            if (response.data === 1) {
              this.challenge.attachments.splice(index, 1);
              this.$forceUpdate();
            }
          });
        }
      });
    },
    getYoutube(url) {
      return Utils.getYoutube(url)
    },
    addAttachment() {
      this.attachment.challenge_id = this.challenge.id;
      axios
        .post("/classroom/challenge/attachment", {
          attachment: this.attachment
        })
        .then(response => {
          this.isAttachmentModalActive = false;
          this.challenge.attachments.push(response.data);
          this.$parent().$forceUpdate();
        });
    },
    markCompleted(challenge) {
      this.$buefy.dialog.confirm({
        title: "Class change",
        message:
          "Are you sure you have done all the the work? Trust is needed there.",
        confirmText: "Confirm done",
        type: "is-warning",
        iconPack: "fa",
        hasIcon: true,
        onConfirm: () => {
          axios
            .post("/classroom/" + this.code + "/student/markchallenge", {
              challenge: this.challengeReactive.id
            })
            .then(response => {
              if (response.data.success == true) {
                confetti({
                  particleCount: 200,
                  spread: 100,
                  origin: { y: 1.0 }
                });
                this.challengeReactive.count++;
                this.$parent.$parent.$parent.student.hp = response.data.hp;
                this.$parent.$parent.$parent.student.xp = response.data.xp;
                this.$parent.$parent.$parent.student.gold = response.data.gold;
                this.$parent.$parent.$parent.forceReload++;
              }
            });
        }
      });
    }
  },
  components: {},
  computed: {
    checkCompletion() {
      if (this.challengeReactive.completion == 1)
        return this.challengeReactive.count == 1;
      if (this.challengeReactive.completion == 2)
        return this.challengeReactive.count == 2;
    },
    getBackground() {
      if (this.full) {
        if (this.challengeReactive.is_conquer == 1) {
          return "has-background-conquer";
        } else {
          return "has-background-story";
        }
      } else if (this.edit) {
        return "";
      } else {
        switch (this.challengeReactive.completion) {
          case 0:
          case 1:
            return this.challengeReactive.count == 1
              ? "has-background-success"
              : "has-background-danger";
            break;
          case 2:
            return this.challengeReactive.count == 2
              ? "has-background-success"
              : "has-background-danger";
            break;
        }
      }
    }
  }
};
</script>
