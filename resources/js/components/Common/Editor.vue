<script>
import { defineComponent } from 'vue'
import { VueEditor } from 'vue3-editor'

export default defineComponent({
    name: 'Editor',

    components: {
        VueEditor
    },

    data: () => ({
        content: null
    })
})
</script>

<template>
    <vue-editor v-model='content'/>
</template>

<style scoped>

</style>
