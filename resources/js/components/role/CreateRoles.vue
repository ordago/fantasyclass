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
            <button class="button is-primary mt-3">{{ trans.get('roles.create') }}</button>
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
