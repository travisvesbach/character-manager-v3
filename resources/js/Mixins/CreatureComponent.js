export const CreatureComponent = {
    props: ['creature', 'type'],
    emits: ['updated'],
    computed: {
        ownerOrAdmin() {
            if(this.$page.props.user.id == this.creature.user_id || this.$page.props.user.admin) {
                return true;
            }
            return false;
        },
        disabled() {
            if(this.type == 'Monster') {
                return true;
            }
            return false;
        }
    },
    methods: {
        updateCreature(no_alert = false) {
            if(no_alert) {
                this.creature.no_alert = no_alert;
            }
            this.$emit('updated', this.creature);
        }
    }
}
