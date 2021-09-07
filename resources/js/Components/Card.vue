<template>
    <div class="md:container shadow overflow-hidden sm:rounded-lg mx-auto card">
        <div class="card-header-footer" v-if="hasHeader">
            <slot name="header"></slot>
        </div>

        <div class="p-3">
            <slot></slot>
        </div>

        <div class="p-3 flex items-center card-header-footer" v-if="hasFooter">
            <slot name="footer"></slot>
            <div class="flex flex-grow items-center justify-end">
                <slot name="footerend"></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            hasHeader() {
                return !! this.$slots.header
            },
            hasFooter() {
                return !! this.$slots.footer || this.$slots.footerend
            },
        }
    }
</script>
