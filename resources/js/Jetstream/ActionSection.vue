<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <jet-section-title>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </jet-section-title>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <card>
                <slot name="content"></slot>
            </card>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetSectionTitle from './SectionTitle.vue'
    import Card from '@/Components/Card'

    export default defineComponent({
        components: {
            JetSectionTitle,
            Card,
        }
    })
</script>
