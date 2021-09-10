<template>
    <div class="inline-block px-1 mx-1 rounded-md text-xs" :class="colorClasses">
        {{ value }}
    </div>
</template>

<script>

    export default {
        props: ['value', 'color'],

        computed: {
            colorClasses() {
                switch(this.color) {
                    case 'light-gray':
                        return 'bg-gray-300 dark:bg-gray-500'
                        break;
                    default:
                        return 'bg-gray-200 dark:bg-gray-600';
                }
            },
        },
    }
</script>
