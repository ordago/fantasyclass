<template>
    <div class="has-padding-4">
        <div class="field is-horizontal">
            <form @submit.prevent="addMap">
                <div class="field-body">
                    <div class="field is-expanded">
                    <div class="field has-addons">
                        <p class="control">
                            <a class="button is-static">
                                <i class="far fa-user-plus"></i>
                            </a>
                        </p>
                        <p class="control is-expanded">
                            <input class="input" v-model="mapActive" required type="checkbox">
                        </p>
                        <p class="control is-expanded">
                            <input class="input" v-model="mapUrl" type="text" placeholder="Map url">
                        </p>
                        <p class="control">
                            <button class="button is-primary">
                                +
                            </button>
                        </p>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
  export default {
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data: function() {
            return {
                map: [
                ],
                csrfToken: null,
            }
        },
    }
</script>
