<template>
    <div class="col-span-1 border dark:border-gray-700 flex flex-col">
        <div class="p-2 flex justify-between" v-if="title || $slots.button">
            <p class="text-xl">
                {{ title }}
            </p>
            <slot name="button"/>
        </div>
        <div class="px-2 p-1 bg-gray-50 border-t dark:bg-gray-800 dark:border-gray-700 flex-grow">
            <slot/>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title'],
}
</script>
