import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

import { Flash } from '@/Mixins/Flash';
import { CreatureBase } from '@/Mixins/Creature/Base';
import { CreatureSkills } from '@/Mixins/Creature/Skills';

export const CreatureStats = {

    components: {
        JetButton,
        JetSecondaryButton,
    },
    mixins: [Flash, CreatureBase, CreatureSkills],
    data() {
        return {
            rest_length: null,
        }
    },
    methods: {
        roll(item, modifier, type) {
            let modifiers = this.creature.modifiers.filter(value => value.enabled && value[type]);
            let total = dice.roll();
            let message = this.creature.display_name + ':<br>' + item + ': [' + total + ']' + (modifier ? ' + ' + modifier : '');

            total += modifier;
            for(const mod of modifiers) {
                for(const mod_dice of mod[type + '_dice']) {
                    message += (mod_dice.count > 0 ? ' + [' : '');
                    for(let x=0;x<mod_dice.count;x++) {
                        let result = dice.roll(mod_dice.size);
                        message += (x > 0 ? ', ' : '') + result;
                        total += result;
                    }
                    message += mod_dice.count > 0 ? ']' : '';
                    if(mod_dice.modifier) {
                        message += (mod_dice.modifier ? ' + ' + mod_dice.modifier : '');
                        total += mod_dice.modifier;
                    }
                    message += ' [' + mod.name + ']';
                }
            }
            message += ' = ' + (total);
            this.flash(message, 'primary');
        },
        displayStat(stat) {
            return (stat > 0 ? '+' : '') + stat;
        },
    }
}
