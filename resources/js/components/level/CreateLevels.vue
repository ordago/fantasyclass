<template>
    <form method="post" action="">
        <input :value="csrfToken" type="hidden" name="_token"/>
        <div class="has-padding-4">
            <div>
                <span>
                    How many levels do you want?
                </span> 
                <input type="number" class="input" name="levels" value="10">
            </div>
            <div class="has-margin-top-4">
                <span>
                    Increment in XP
                </span> 
                <input type="number" name="increment" class="input" value="100">
                <small>
                    Don't worry, you will be able to change this.
                </small>
            </div>
            <button class="button is-primary has-margin-top-3">Create</button>
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
