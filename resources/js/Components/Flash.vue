<template>
    <div class="h-full">
        <div class="alert-flash flex flex-col items-end">
            <div id="alert" class="rounded py-3 px-5 my-2 opacity-90" v-bind:class="getStatusClasses(messageObj.status)" role="alert" v-for="messageObj in flash_array">
                <span v-html="messageObj.message"/>
            </div>
        </div>


        <button class="nav-link nav-link-inactive link-color" :title="'View the last ' + flash_history.length + ' flash messages'" @click="show_modal = true">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
        </button>

       <!-- action modal -->
        <jet-dialog-modal :show="show_modal" max-width="2xl" @close="show_modal = false">
            <template #header>
                Flash Messages
            </template>

            <template #content>
                <div class="flex justify-between">
                    <span>History limit: {{ flash_history.length }}/{{ history_max }}</span>

                    <jet-danger-button size="sm" @click="clearHistory">
                        Clear
                    </jet-danger-button>
                </div>

                <div class="rounded py-3 px-5 my-2 opacity-90" v-bind:class="getStatusClasses(messageObj.status)" v-for="messageObj in flash_history">
                    <span v-html="messageObj.message"/>
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
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetDialogModal from '@/Jetstream/DialogModal'

    export default {
        components: {
            JetButton,
            JetDialogModal,
            JetDangerButton,
        },
        props: ['message', 'status', 'timestamp'],
        data() {
            return {
                flash_array: [],
                flash_history: [],
                history_max: 20,
                show_modal: false,
            }
        },
        created() {

            if(sessionStorage.getItem('flash_history')) {
                this.flash_history = JSON.parse(sessionStorage.getItem('flash_history'));
            }
            if(!Array.isArray(this.flash_history)) {
                this.flash_history = [];
            }

            if (this.message) {
                this.flash(this.message);
            }
        },
        watch: {
            timestamp: function() {
                if(this.message) {
                    this.flash();
                }
            }
        },
        methods: {
            getStatusClasses(status) {
                return {
                    'bg-green-100 text-green-800': status == 'success',
                    'bg-red-200 text-red-900': status == 'danger',
                    'bg-blue-200 text-blue-800': status == 'info',
                    'bg-indigo-200 text-indigo-800': status == 'primary'
                }
            },
            flash() {
                let message = {
                    message: this.message,
                    status: this.status
                };

                this.flash_array.push(message);

                this.flash_history.unshift(message);
                this.flash_history.length = Math.min(this.flash_history.length, this.history_max);
                sessionStorage.setItem('flash_history', JSON.stringify(this.flash_history));

                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.flash_array.shift();
                }, 5000);
            },
            clearHistory() {
                this.flash_history = [];
                sessionStorage.setItem('flash_history', JSON.stringify(this.flash_history));
            }
        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 9999;
        max-width: 25rem;
    }
</style>
