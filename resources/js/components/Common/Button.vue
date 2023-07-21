<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'Button',

    props: {
        type: String,
        onClick: Function,
        disabled: Boolean
    }
})
</script>

<template>
    <button
        :type='type'
        :disabled='disabled'
        @click.prevent='onClick'
        class='btn btn-outline-dark my-5'
    >
        <slot></slot>
    </button>
</template>

<style scoped>

</style>
