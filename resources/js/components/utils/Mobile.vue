<template>
  <div class="p-3 fs-1-2 has-background-light has-text-centered" style="height: 90vh">
    <b-tabs type="is-toggle" expanded>
      <b-tab-item label="Android" icon-pack="fab" icon="android">
        <div class="p-3">
          <div class="notification is-info is-light mb-1" v-html="trans.get('utils.mobile_text_android')">
          </div>
          <a
            href="https://play.google.com/store/apps/details?id=app.fantasyclass.climentjoan"
            target="_blank"
            ><img width="300px" alt="google play logo" src="/gplay.png"
          /></a>
        </div>
      </b-tab-item>
      <b-tab-item label="iOs (iPhone & iPad)" icon-pack="fab" icon="apple">
        <div class="p-3">
           <div class="notification is-warning is-light mb-1" v-html="trans.get('utils.mobile_text_apple')">
          </div>
          <video controls width="300px">
            <source src="/videos/ios.mp4" type="video/mp4" />
          </video>
        </div>
      </b-tab-item>
    </b-tabs>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  mounted() {},
  methods: {},
};
</script>