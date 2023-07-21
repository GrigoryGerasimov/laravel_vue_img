<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'Image',

    props: {
        image: Object
    }
})
</script>

<template>
    <img
        :src='image.url'
        :alt='image.path'
        class='w-25 my-2'
    />
</template>

<style scoped>

</style>
