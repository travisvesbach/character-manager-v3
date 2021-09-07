<template>
    <form @submit.prevent="$emit('submitted')" class="w-full md:w-1/2 mx-auto py-10 sm:px-6 lg:px-8 m-2">
        <card>
            <slot></slot>
            <template #footerend v-if="hasActions">
                <slot name="actions"></slot>
            </template>
        </card>
    </form>
</template>

<script>
    import Card from '@/Components/Card'

    export default {
        components: {
            Card,
        },
        computed: {
            hasActions() {
                return !! this.$slots.actions;
            },
        }
    }
</script>
