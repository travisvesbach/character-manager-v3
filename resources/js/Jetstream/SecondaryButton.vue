<template>
    <button :type="type" class="btn btn-secondary" :class="sizeClass">
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
            size: {
                type: String,
                default: 'md',
            }
        },
        computed: {
            sizeClass() {
                return {
                    'xs': 'btn-xs',
                    'sm': 'btn-sm',
                    'md': '',
                }[this.size]
            }
        }
    })
</script>
