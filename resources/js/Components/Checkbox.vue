<template>
        <input type="checkbox" :model="modelValue" :checked="modelValue" @input="$emit('update:modelValue', $event.target.checked)">
</template>

<script>

    export default {
        props: ['modelValue'],
        emits: ['update:modelValue'],
        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>
