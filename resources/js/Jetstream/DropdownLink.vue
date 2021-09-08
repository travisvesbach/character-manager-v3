<template>
    <div>
        <button type="submit" class="block w-full px-4 py-2 text-sm leading-5 text-left focus:outline-none transition" :class="colorClasses" v-if="as == 'button'">
            <slot></slot>
        </button>

        <a :href="href" class="block px-4 py-2 text-sm leading-5 focus:outline-none transition" :class="colorClasses" v-else-if="as =='a'">
            <slot></slot>
        </a>

        <Link :href="href" class="block px-4 py-2 text-sm leading-5 focus:outline-none transition" :class="colorClasses" v-else>
            <slot></slot>
        </Link>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: ['href', 'as'],
        computed: {
            colorClasses() {
                // return 'text-gray-700 hover:bg-gray-100 focus:bg-gray-100 dark:text-green dark:hover:bg-gray-600';
                return 'hover:bg-gray-100 dark:hover:bg-gray-600 link-color';
            }
        }
    })
</script>
