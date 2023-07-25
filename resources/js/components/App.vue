<script>
import { defineComponent } from 'vue'
import { Button, Divider, Editor } from './Common'
import { FormControl, DropzoneField } from './Form'
import Post from './Post/Post.vue'

export default defineComponent({
    name: 'App',

    components: {
        DropzoneField,
        Button,
        Divider,
        Post,
        FormControl,
        Editor
    },

    data: () => ({
        title: null,
        images: null,
        dropZone: null,
        posts: null,
        content: null
    }),

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

        async store() {
            try {
                const data = new FormData()
                data.append('title', this.title)
                this.images.forEach(img => {
                    data.append('images[]', img)
                    this.dropZone.removeFile(img)
                })
                this.title = null

                await axios.post('/api/posts', data)

                await this.getAll()
            } catch (err) {
                console.log(err)
            }
        },

        async getAll() {
            const response = await axios.get('/api/posts')
            this.posts = response.data
        }
    },

    mounted() {
        this.getAll()
    }
})
</script>

<template>
    <FormControl
        id='title'
        label='Title'
        name='title'
        placeholder='title'
        v-model='title'
    />
    <DropzoneField @files-added='getDzFiles'/>
    <Editor/>
    <Button type='submit' :onClick='store' :disabled='isDisabled'>Send</Button>
    <Divider/>
    <div v-show='posts' v-for='post in posts'>
        <Post :post='post'/>
    </div>
</template>

<style scoped>

</style>
