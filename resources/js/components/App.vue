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
        content: null,
        postIdToUpdate: null,
        postToUpdate: null,
        imageIdsToRemove: [],
        imageUrlsToRemove: []
    }),

    watch: {
        async postIdToUpdate() {
            await this.getOne()
            this.title = this.postToUpdate.title

            this.postToUpdate.images.forEach(img => {
                const file = {
                    id: img.id,
                    name: img.path,
                    size: img.size
                }
                this.dropZone.displayExistingFile(file, img.preview_url)
            })
        },
    },

    computed: {
        isDisabled() {
            return !(this.title && this.content)
        }
    },

    methods: {
        getDz(dropZone) {
            this.dropZone = dropZone
        },

        getDzFiles(dropZone) {
            this.images = dropZone.getAcceptedFiles()
        },

        getDzRemovedFileId(id) {
            this.imageIdsToRemove.push(id)
        },

        getContent(content) {
            this.content = content
        },

        getPostIdToUpdate(postId) {
            this.postIdToUpdate = postId;
        },

        async getAll() {
            const response = await axios.get('/api/posts')
            this.posts = response.data
        },

        async getOne() {
            const response = await axios.get(`/api/posts/${this.postIdToUpdate}`)
            this.postToUpdate = response.data
        },

        async store() {
            try {
                const data = new FormData()
                data.append('title', this.title)
                data.append('content', this.content)

                if (this.images && this.images.length) {
                    this.images.forEach(img => {
                        data.append('images[]', img)
                        this.dropZone.removeFile(img)
                    })
                }

                this.title = null

                await axios.post('/api/posts', data)

                await this.getAll()
            } catch (err) {
                console.log(err)
            }
        },

        async update() {
            try {
                const data = new FormData()
                data.append('title', this.title)
                data.append('content', this.content)
                data.append('_method', 'PATCH')

                if (this.imageIdsToRemove.length) {
                    this.imageIdsToRemove.forEach(imageId => {
                        data.append('image_ids_to_remove[]', imageId)
                    })
                }

                if (this.images && this.images.length) {
                    this.images.forEach(img => {
                        data.append('images[]', img)
                        this.dropZone.removeFile(img)
                    })
                }

                this.title = null

                await axios.post(`/api/posts/${this.postIdToUpdate}`, data)

                await this.getAll()
            } catch (err) {
                console.log(err)
            }
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
    <DropzoneField @dropzone-init='getDz' @files-added='getDzFiles' @file-removed='getDzRemovedFileId'/>
    <Editor @emit-content='getContent' :postToUpdate='postToUpdate'/>
    <Button type='submit' :onClick='this.postIdToUpdate ? update : store' :disabled='isDisabled'>Send</Button>
    <Divider/>
    <div v-show='posts' v-for='post in posts'>
        <Post :post='post' @get-post-id='getPostIdToUpdate'/>
    </div>
</template>

<style scoped>

</style>
