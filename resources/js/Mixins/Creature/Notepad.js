import { Flash } from '@/Mixins/Flash';
import { CreatureBase } from '@/Mixins/Creature/Base';

export const CreatureNotepad = {
    mixins: [Flash, CreatureBase],
    data() {
        return {
            notes: this.creature.notes,
        }
    },
    methods: {
        update() {
            if(this.notes != this.creature.notes) {
                this.creature.notes = this.notes;
                this.updateCreature(true);
            }
        }
    }
}
