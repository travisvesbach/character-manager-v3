<template>
    <modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <card>
            <template #header v-if="$slots.header">
                <slot name="header"></slot>
            </template>
            <div class="text-lg mb-2">
                <slot name="title"></slot>
            </div>

            <slot name="content"></slot>

            <template #footerend>
                <slot name="footer"></slot>
            </template>
        </card>
    </modal>
</template>

<script>
    import { defineComponent } from 'vue'
    import Modal from './Modal.vue'
    import Card from '@/Components/Card'

    export default defineComponent({
        emits: ['close'],

        components: {
            Modal,
            Card,
        },

        props: {
            show: {
                default: false
            },
            maxWidth: {
                default: '2xl'
            },
            closeable: {
                default: true
            },
        },

        methods: {
            close() {
                this.$emit('close')
            },
        }
    })
</script>
