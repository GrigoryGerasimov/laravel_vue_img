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
    }),

    methods: {
        async imageAddingHandler(file, Editor, cursorLocation, resetUploader) {
            try {
                const data = new FormData()
                data.append('image', file)

                const response = await axios.post('/api/posts/images', data)
                const url = response.data.url

                Editor.insertEmbed(cursorLocation, 'image', url)
                resetUploader()
            } catch (err) {
                console.log(err)
            }
        }
    },

    updated() {
        this.$emit('emitContent', this.content)
    }
})
</script>

<template>
    <vue-editor
        useCustomImageHandler
        @image-added='imageAddingHandler'
        v-model='content'
    />
</template>

<style scoped>

</style>
