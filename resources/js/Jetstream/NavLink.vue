<template>
    <Link :href="href" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition h-full" :class="classes">
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
                    ? 'border-indigo-400 text-gray-900 focus:border-indigo-700 dark:text-green-light dark:border-green-light dark:focus:border-green-light'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300 dark:text-green dark:hover:text-green-light dark:hover:border-green-light dark:focus:text-green-light dark:focus:border-green-light'
            }
        }
    })
</script>
