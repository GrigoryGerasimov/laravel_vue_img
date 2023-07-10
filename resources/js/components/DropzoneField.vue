<script>
import { defineComponent } from 'vue'
import { Dropzone } from 'dropzone'

export default defineComponent({
    name: 'DropzoneField',

    data() {
        return {
            dz: null
        }
    },

    mounted() {
        this.dz = new Dropzone(this.$refs['dz-field'], {
            url: 'test'
        })
    }
})
</script>

<template>
    <div ref='dz-field' class='w-50 py-4 px-5 bg-dark text-light text-center'>
        <span class='d-inline-block mx-auto width-fit my-3'>Upload</span>
        <div class='fallback mx-auto width-fit my-3'>
            <input type='file' name='file'/>
        </div>
    </div>
</template>

<style scoped>
.width-fit {
    width: fit-content;
}
</style>
