<template>
    <modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <component :is="type" @submit.prevent="type == 'form' ? $emit('submitted') : ''">
            <card>
                <template #header v-if="$slots.header">
                    <slot name="header"></slot>
                </template>
                <div class="text-lg mb-2">
                    <slot name="title"></slot>
                </div>

                <slot name="content"></slot>

                <template #footer v-if="hasFooter">
                    <slot name="footer"></slot>
                </template>

                <template #footerend v-if="hasFooterEnd">
                    <slot name="footerend"></slot>
                </template>
            </card>
        </component>
    </modal>
</template>

<script>
    import { defineComponent } from 'vue'
    import Modal from './Modal.vue'
    import Card from '@/Components/Card'

    export default defineComponent({
        emits: ['close', 'submitted'],

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
            type: {
                default: 'div'
            },
        },
        computed: {
            hasFooter() {
                return !! this.$slots.footer;
            },
            hasFooterEnd() {
                return !! this.$slots.footerend;
            },
        },
        methods: {
            close() {
                this.$emit('close')
            },
        }
    })
</script>
