<template>
    <div class="accordion-item">
        <div class="cursor-pointer" @click="toggle(!show)">
            <strong>
                <slot name="title"></slot>
            </strong>
            <div class="float-right transform ease-in duration-200" :class="iconClasses">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
        </div>
        <transition-expand>
            <div class="accorion-item-content" v-if="show">
                <slot name="content"></slot>
            </div>
        </transition-expand>
    </div>
</template>

<script>
    import TransitionExpand from '@/Components/TransitionExpand'

    export default {
        inject: ['addItem', 'removeItem', 'setOpen'],
        props: ['id'],
        components: {
            TransitionExpand,
        },
        data() {
            return {
                show: false
            }
        },
        computed: {
            iconClasses() {
                if(this.show) {
                    return '-rotate-90'
                }
            }
        },
        beforeMount() {
            this.addItem(this);
        },
        beforeDestroy() {
            this.removeItem(this);
        },
        methods: {
            toggle(value) {
                if(value != this.show) {
                    this.show = value;
                    this.setOpen(this, value);
                }
            }
        }
    }
</script>
