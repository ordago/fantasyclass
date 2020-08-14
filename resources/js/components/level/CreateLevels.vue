<template>
    <form method="post" action="">
        <input :value="csrfToken" type="hidden" name="_token"/>
        <div class="has-padding-4">
            <div>
                <span>
                    {{ trans.get('levels.number_levels') }}
                </span> 
                <input type="number" class="input" name="levels" value="10">
            </div>
            <div class="has-margin-top-4">
                <span>
                    {{ trans.get('levels.xp_increment') }}
                </span> 
                <input type="number" name="increment" class="input" value="100">
                <small>
                    {{ trans.get('levels.increment_info') }}
                </small>
            </div>
            <button class="button is-primary has-margin-top-3">{{ trans.get('levels.create') }}</button>
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
                levels: [
                ],
                csrfToken: null,
            }
        },
        methods: {
           
        }
    }
</script>
