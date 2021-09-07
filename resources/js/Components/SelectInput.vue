<template>
    <select class="focus:ring focus:ring-opacity-50 rounded-md shadow-sm form-input-color" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
        <option v-for="option in options">{{ option }}</option>
    </select>
</template>

<script>

    export default {
        props: ['modelValue', 'options'],
        emits: ['update:modelValue'],
        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>
