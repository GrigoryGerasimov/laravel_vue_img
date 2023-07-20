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
            images: null
        }
    },

    methods: {
        getDzFiles(dropZone) {
            this.images = dropZone.getAcceptedFiles()
        },

        store() {
            console.log(this.images)
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
        />
    </div>
    <DropzoneField @files-added='getDzFiles'/>
    <button
        type='submit'
        class='btn btn-outline-dark my-5'
        @click.prevent='store'
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
