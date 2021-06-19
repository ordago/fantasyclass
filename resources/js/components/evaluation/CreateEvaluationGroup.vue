<template>
    <div class="pl-0-desktop p-2">
        <div class="panel pl-0">
            <p class="panel-heading is-flex has-space-between align-items-center p-4">
                <span class="pl-3">Create </span>
            </p>
            <div class="p-4 panel-block">
                <form method="post" @submit.prevent="formSubmit" class="w-100" :action="'/classroom/' + this.code + '/evaluation'">
                    <input :value="csrfToken" type="hidden" name="_token" />
                    <div class="my-3">
                        <label for="name"><span class="help is-danger is-inline">* </span> {{ trans.get('evaluation.icon') }}</label>
                    </div>
                    <div class="field has-addons">
                        <p class="control">
                            <IconSelector></IconSelector>
                        </p>
                        <p class="control is-expanded">
                            <input v-model="icon" ref="icon" name="icon" class="input" required :placeholder="trans.get('behaviours.icon_select')" type="text" />
                        </p>
                    </div>
                    <div class="form-group" style="margin-top: -10px;">
                        <label><small>{{ trans.get('behaviours.fontawesome') }} <a href="https://fontawesome.com/icons?d=gallery" target="_blank">FontAwesome</a></small></label>
                    </div>
                    <div class="mt-3">
                        <label for="name"><span class="help is-danger is-inline">* </span> {{ trans.get('evaluation.name') }}</label>
                        <input type="text" id="name" v-model="evaluationInfo.name" name="name" required class="input my-3">
                    </div>
                    <div class="mt-3">
                        <button class="button is-link" @click="update" v-if="evaluation" type="button">{{ trans.get('evaluation.edit') }}</button>
                        <button class="button is-success" type="submit" v-if="!evaluation">{{ trans.get('evaluation.create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    const IconSelector = () => import("../utils/IconSelector.vue");

    export default {
        props: ['code', 'evaluation', 'editgroup'],
        created() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
            if (this.editgroup)
                this.evaluationInfo = this.editgroup
        },
        data: function () {
            return {
                csrfToken: null,
                evaluationInfo: {
                    id: null,
                    icon: this.icon,
                    name: null,
                },
                icon: 'fas fa-chart-line',
            }
        },
        components: {
            IconSelector
        },
        methods: {
            formSubmit: function (e) {
                this.evaluationInfo.icon = this.icon;
                axios.post('/classroom/' + this.code + '/evaluation/group', this.$data.evaluationInfo)
                    .then(response => {
                        this.$toasted.show(response.data.message, {
                            position: "top-center",
                            duration: 3000,
                            iconPack: 'fontawesome',
                            icon: response.data.icon,
                            type: response.data.type,
                        })

                        if (response.data.evaluable) {
                            this.$parent.refresh(response.data.evaluable);
                        }
                    });
                this.$parent.activeAddGroup = false;
                this.$parent.$forceUpdate();
            }
        },
    }
</script>
