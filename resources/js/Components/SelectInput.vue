<template>
    <select class="focus:ring focus:ring-opacity-50 rounded-md shadow-sm form-input-color" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
        <option v-for="option in options" :value="optionContents(option, 0)">{{ optionContents(option, 1) }}</option>
    </select>
</template>

<script>

    export default {
        props: ['modelValue', 'options'],
        emits: ['update:modelValue'],
        methods: {
            focus() {
                this.$refs.input.focus()
            },
            optionContents(option, selector) {
                if(Array.isArray(option)) {
                    return option[selector];
                }
                return option;
            }
        }
    }
</script>
