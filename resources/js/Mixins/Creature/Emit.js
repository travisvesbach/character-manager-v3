export const creatureEmit = {
    emits: ['updated'],
    methods: {
        updateCreature() {
            this.$emit('updated', this.creature);
        }
    }
}
