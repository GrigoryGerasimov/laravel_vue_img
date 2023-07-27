<script>
import { defineComponent } from 'vue'
import { VueEditor } from 'vue3-editor'

export default defineComponent({
    name: 'Editor',

    components: {
        VueEditor
    },

    props: {
        postToUpdate: Object,
        updatedContent: String
    },

    data() {
        return {
            content: null
        }
    },

    watch: {
        postToUpdate() {
            this.content = this.postToUpdate.content
        },
        updatedContent() {
            this.content = this.updatedContent
        }
    },

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
        },

        async imageRemovingHandler(file) {
            this.$emit('emitRemovedFileId', file)
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
        @image-removed='imageRemovingHandler'
        @image-added='imageAddingHandler'
        v-model='content'
    />
</template>

<style scoped>

</style>
