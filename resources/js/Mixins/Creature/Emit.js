export const creatureEmit = {
    emits: ['updated'],
    methods: {
        updateCreature(no_alert = false) {
            if(no_alert) {
                console.log('here');
                this.creature.no_alert = no_alert;
            }
            this.$emit('updated', this.creature);
        }
    }
}
