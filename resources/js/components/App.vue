<script>
import { defineComponent } from 'vue'
import DropzoneField from './DropzoneField.vue'

export default defineComponent({
    name: 'App',

    components: {
        DropzoneField
    },

    data() {
        return {
            title: null,
            images: null,
            dropZone: null
        }
    },

    computed: {
        isDisabled() {
            return !(this.title && this.images)
        }
    },

    methods: {
        getDzFiles(dropZone) {
            this.dropZone = dropZone
            this.images = dropZone.getAcceptedFiles()
        },

        store() {
            const data = new FormData()
            data.append('title', this.title)
            this.images.forEach(img => {
                data.append('images[]', img)
                this.dropZone.removeFile(img)
            })
            axios.post('api/posts', data)
        }
    }
})
</script>

<template>
    <div class='input-group d-flex flex-row align-items-baseline'>
        <label for='title' class='form-label me-5'>Title</label>
        <input
            id='title'
            name='title'
            placeholder='title'
            class='form-control form-control-custom my-5'
            v-model='title'
        />
    </div>
    <DropzoneField @files-added='getDzFiles'/>
    <button
        type='submit'
        class='btn btn-outline-dark my-5'
        @click.prevent='store'
        :disabled='isDisabled'
    >
        Send
    </button>
</template>

<style scoped>
.form-control-custom {
    max-width: 250px;
    border-top: none;
    border-right: none;
    border-left: none;
}
</style>
