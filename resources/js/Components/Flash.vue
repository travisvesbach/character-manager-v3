<template>
    <div class="alert-flash flex flex-col items-end">
        <div id="alert" class="rounded py-3 px-5 my-2 opacity-90" v-bind:class="getStatusClasses(messageObj.status)" role="alert" v-for="messageObj in messageArray">
            <span v-html="messageObj.message"/>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message', 'status', 'timestamp'],
        data() {
            return {
                messageArray: []
            }
        },
        created() {
            if (this.message) {
                this.flash(this.message);
            }
        },
        watch: {
            timestamp: function() {
                this.flash();
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
                this.messageArray.push({
                    message: this.message,
                    status: this.status
                });

                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.messageArray.shift();
                }, 5000);
            }
        }
    };
</script>

<style>
    .alert-flash {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 9999;
    }
</style>
