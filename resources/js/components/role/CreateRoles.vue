<template>
    <form method="post" action="">
        <input :value="csrfToken" type="hidden" name="_token"/>
        <div class="p-4">
            <div>
                <span>
                    {{ trans.get('roles.number_roles') }}
                </span> 
                <input type="number" class="input mt-2" name="roles" value="4">
            </div>
            <div class="is-flex is-center-vertically mt-3">
            <button class="button is-primary mr-1">{{ trans.get('roles.create') }}</button> 
            {{ trans.get('roles.or') }} <button class="button is-info ml-1" @click.prevent="$parent.importDefault">{{ trans.get('roles.import_default') }}</button>
            </div>
        </div>
    </form>
</template>

<script>
  export default {
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data: function() {
            return {
                roles: [
                ],
                csrfToken: null,
            }
        },
        methods: {
           
        }
    }
</script>
