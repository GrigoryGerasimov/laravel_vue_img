<script>
import { defineComponent } from 'vue'
import Image from '../Image/Image.vue'
import Button from "../Common/Button.vue";

export default defineComponent({
    name: 'Post',

    components: {
        Button,
        Image
    },

    props: {
        post: Object
    },

    methods: {
        handleClick(id) {
            this.$emit('getPostId', id)
        }
    }
})
</script>

<template>
    <div class='my-5'>
        <div class='d-flex flex-row justify-content-between align-items-baseline'>
            <div>
                <strong>{{ post.title }}</strong>
            </div>
            <div>
                <Button @click='handleClick(post.id)'>Edit</Button>
            </div>
        </div>

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
