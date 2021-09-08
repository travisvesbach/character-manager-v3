<template>
    <div class="md:col-span-1 flex justify-between">
        <div class="px-4 sm:px-0">
            <heading>
                <slot name="title"></slot>
            </heading>

            <p class="mt-1 text-sm text-secondary-color">
                <slot name="description"></slot>
            </p>
        </div>

        <div class="px-4 sm:px-0">
            <slot name="aside"></slot>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import Heading from '@/Components/Heading'

    export default defineComponent({
        components: {
            Heading,
        }
    })
</script>
