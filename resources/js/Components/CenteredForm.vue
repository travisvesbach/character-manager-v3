<template>
    <form @submit.prevent="$emit('submitted')" class="w-full mx-auto py-10" :class="'md:w-' + width">
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
        props: {
            width: {
                default: '1/2'
            }
        },
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
