<template>
    <Link :href="href" class="nav-link" :class="classes">
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
                    ? 'nav-link-active'
                    : 'nav-link-inactive link-color'



            }
        }
    })
</script>
