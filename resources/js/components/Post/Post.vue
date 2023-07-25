<script>
import { defineComponent } from 'vue'
import Image from '../Image/Image.vue'

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
        <div v-show='post.images' v-for='img in post.images'>
            <div class='mb-1'>
                <Image :image='img' :src='img.preview_url'/>
            </div>
            <div>
                <Image :image='img' :src='img.url' class='w-75'/>
            </div>
        </div>
        <div class='ql-editor' v-html='post.content'></div>
    </div>
</template>

<style scoped>

</style>
