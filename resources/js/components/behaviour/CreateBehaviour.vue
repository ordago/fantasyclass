<template>
    <div class="container bg-light h-100 w-100">
        <form method="post" @submit="formSubmit" :action="'/classroom/' + this.code + '/behaviours'" enctype="multipart/form-data">
            <input :value="csrfToken" type="hidden" name="_token"/>

        </form>
    </div>
</template>

<script>


  export default {
    
        created() {
          this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data: function() {
            return {
                icon: null,
                csrfToken: null,
                code: null,
            }
        },
        methods: {
            formSubmit: function(e) {  
              e.preventDefault()
            },
        },
    }
</script>