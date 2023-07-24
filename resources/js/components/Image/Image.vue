<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'Image',

    props: {
        image: Object,
        src: String
    }
})
</script>

<template>
    <img
        :src='src'
        :alt='image.path'
        class='my-2'
    />
</template>

<style scoped>

</style>
