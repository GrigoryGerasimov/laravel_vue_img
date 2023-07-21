<script>
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'FormControl',

    props: {
        id: String,
        label: String,
        name: String,
        placeholder: String,
        modelValue: String
    },

    emits: [
        'update:modelValue'
    ]
})
</script>

<template>
    <div class='input-group d-flex flex-row align-items-baseline'>
        <label :for='id' class='form-label me-5'>{{ label }}</label>
        <input
            :id='id'
            :name='name'
            :placeholder='placeholder'
            :value='modelValue'
            class='form-control form-control-custom my-5'
            @input="$emit('update:modelValue', $event.target.value)"
        />
    </div>
</template>

<style scoped>
.form-control-custom {
    max-width: 250px;
    border-top: none;
    border-right: none;
    border-left: none;
}
</style>
