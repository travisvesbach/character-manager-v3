<template>
    <Link :href="href" class="inline-flex items-center ml-3 px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition h-full" :class="classes">
        <slot />
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                    ? 'border-indigo-400 text-gray-900 focus:border-indigo-700 dark:text-yellow-500 dark:border-yellow-500 dark:focus:border-yellow-500'
                    : 'border-transparent dark:hover:border-yellow-500 dark:focus:border-yellow-500 link-color'



            }
        }
    })
</script>
