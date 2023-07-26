<script>
import { defineComponent } from 'vue'
import { Dropzone } from 'dropzone'

export default defineComponent({
    name: 'DropzoneField',

    data: () => ({
        dz: null
    }),

    mounted() {
        this.dz = new Dropzone(this.$refs['dz-field'], {
            url: 'test',
            autoProcessQueue: false,
            addRemoveLinks: true
        })

        this.$emit('dropzoneInit', this.dz)

        this.dz.on('addedfiles', () => {
            this.$emit('filesAdded', this.dz)
        })
    },
})
</script>

<template>
    <div ref='dz-field' class='w-50 py-4 px-5 mb-5 bg-dark text-light text-center'>
        <span class='d-inline-block mx-auto width-fit my-3'>Upload</span>
        <div class='fallback mx-auto width-fit my-3'>
            <input type='file' name='file'/>
        </div>
    </div>
</template>

<style>
.width-fit {
    width: fit-content;
}
.dz-success-mark,
.dz-error-mark {
    display: none
}
</style>
