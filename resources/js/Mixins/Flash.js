export const flash = {
    methods: {
        flash(message, status) {
                this.$page.props.flash.message = message;
                this.$page.props.flash.status = status;
                this.$page.props.flash.timestamp = Date.now();
        }
    }
}
