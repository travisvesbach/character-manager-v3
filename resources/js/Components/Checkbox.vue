<template>
    <label class="block font-medium text-sm">
        <input type="checkbox" :model="modelValue" :checked="modelValue" @input="$emit('update:modelValue', $event.target.checked)"> {{ label }}
    </label>
</template>

<script>

    export default {
        props: ['modelValue', 'label'],
        emits: ['update:modelValue'],
        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>
