<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <jet-section-title>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </jet-section-title>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="$emit('submitted')">
                <card>
                    <slot name="form"></slot>
                    <template #footerend v-if="hasActions">
                        <slot name="actions"></slot>
                    </template>
                </card>
            </form>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetSectionTitle from './SectionTitle.vue'
    import Card from '@/Components/Card'

    export default defineComponent({
        emits: ['submitted'],

        components: {
            JetSectionTitle,
            Card,
        },

        computed: {
            hasActions() {
                return !! this.$slots.actions
            }
        }
    })
</script>
