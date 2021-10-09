<template>
    <div class="accordion-item">
        <button class="btn-text flex items-center" :class="buttonClasses" @click="toggle(!show)">
            <strong>
                <slot name="title"></slot>
            </strong>
            <svg xmlns="http://www.w3.org/2000/svg" class="transform ease-in duration-200" :class="iconClasses" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
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
        props: ['id', 'justify', 'icon_size', 'button_width'],
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
                let classes = ''
                if(this.show) {
                    classes += ' -rotate-90';
                }

                if(this.icon_size == 'sm') {
                    classes += ' h-3 w-3';
                } else {
                    classes += ' h-4 w-4';
                }
                return classes;
            },
            buttonClasses() {
                let classes = '';
                if(this.button_width) {
                    classes += this.button_width;
                } else {
                    classes += 'w-full';
                }
                if(this.justify) {
                    classes += ' justify-' + this.justify;
                } else {
                    classes += ' justify-between';
                }
                return classes;
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
