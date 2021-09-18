<template>
    <button :type="type" class="btn btn-secondary" :class="small ? 'btn-small' : ''">
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            type: {
                type: String,
                default: 'button',
            },
            small: {
                type: Boolean,
                default: false,
            }
        }
    })
</script>
