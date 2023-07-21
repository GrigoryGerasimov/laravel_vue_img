<script>
import { defineComponent } from 'vue'
import Image from '../Image.vue'

export default defineComponent({
    name: 'Post',
    
    components: {
        Image
    },

    props: {
        post: Object
    }
})
</script>

<template>
    <div class='my-5'>
        <strong>{{ post.title }}</strong>
        <div v-for='img in post.images'>
            <Image :image='img'/>
        </div>
    </div>
</template>

<style scoped>

</style>
