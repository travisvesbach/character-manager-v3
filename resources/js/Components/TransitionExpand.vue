<template>
    <transition name="expand" @enter="enter" @afterEnter="afterEnter" @leave="leave">
        <slot></slot>
    </transition>
</template>

<script>
    export default {
        methods: {
            afterEnter(element) {
                element.style.height = 'auto';
            },

            enter(element) {
                const { height } = getComputedStyle(element);

                element.style.height = 0;

                getComputedStyle(element).height;

                setTimeout(() => {
                    element.style.height = height;
                });
            },

            leave(element) {
                const { height } = getComputedStyle(element);

                element.style.height = height;

                getComputedStyle(element).height;

                setTimeout(() => {
                    element.style.height = 0;
                });
            }
        }
    }
</script>

<style scoped>
    .expand-enter-active,
    .expand-leave-active {
        transition-duration: 0.3s;
        transition-property: height, opacity;
        transition-timing-function: ease;
        overflow: hidden;
    }

    .expand-enter,
    .expand-leave-active {
        opacity: 0
    }
</style>
