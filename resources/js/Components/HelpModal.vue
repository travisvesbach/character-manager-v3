<template>
    <div class="flex">
        <jet-button size="sm" @click="show_modal = true">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </jet-button>

        <!-- action modal -->
        <jet-dialog-modal :show="show_modal" max-width="xl" @close="show_modal = false">
            <template #header v-if="$slots.header">
                <slot name="header"/>
            </template>

            <template #content>
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-2">
                        <slot name="content"></slot>
                    </div>
                </div>
            </template>

            <template #footerend>
                <jet-button class="ml-2" @click="show_modal = false">
                    Close
                </jet-button>
            </template>
        </jet-dialog-modal>
    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'

    export default {
        components: {
            JetButton,
            JetDialogModal,
        },
        data() {
            return {
                show_modal: false,
            }
        },
    }
</script>
