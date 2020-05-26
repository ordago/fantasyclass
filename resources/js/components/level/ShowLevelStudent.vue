<template>
    <div class="column is-6-tablet is-12-mobile is-3-desktop has-margin-bottom-0 is-flex is-all-centered">                    
        <div class="columns w-100 is-variable is-0 has-padding-y-2">
            <div class="column is-narrow has-padding-y-0 card-shadow-s rounded-left">
            <figure class="image is-128x128">
                <img style="width: 128px; height: 128px" :src="level.image" class="has-padding-2 card-shadow-s is-full-rounded">
            </figure>
            </div>
            <div class="column card has-padding-4 rounded-right card-shadow-s">
                <p class="is-size-4">{{ level.title }}</p>
                <p class="">{{ level.description }}</p>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
        props: ['level'],
        mounted() {
           
        },
        data: function() {
            return {
            }
        },
        methods: {
        
        }, 
    }
</script>
