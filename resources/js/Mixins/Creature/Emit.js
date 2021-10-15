export const creatureEmit = {
    data() {
        return {
            rest: null,
        }
    },
    emits: ['updated', 'rest'],
    methods: {
        updateCreature(no_alert = false) {
            if(no_alert) {
                console.log('here');
                this.creature.no_alert = no_alert;
            }
            this.$emit('updated', this.creature);
        },
        takeARest() {
            this.$emit('rest', this.rest);
            this.rest = null;
        }
    }
}
