<template>
    <button :type="type" class="btn btn-primary" :class="small ? 'btn-small' : ''">
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            type: {
                type: String,
                default: 'submit',
            },
            small: {
                type: Boolean,
                default: false,
            }
        }
    })
</script>
