import JetInput from '@/Jetstream/Input'
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import { Link } from '@inertiajs/inertia-vue3'

import { Flash } from '@/Mixins/Flash';
import { CreatureBase } from '@/Mixins/Creature/Base';

export const CreatureHeading = {
    components: {
        JetInput,
        JetButton,
        JetSecondaryButton,
        JetDangerButton,
        JetConfirmationModal,
        Link,
    },
    data() {
        return {
            delete_creature: false,
            hp_calculator: null,
        }
    },
    mixins: [Flash, CreatureBase],
    methods: {
        roll(item, modifier) {
            let result =  dice.roll();
            let message = this.creature.display_name + ':<br>' +
                item + ': [' + result + ']' + (modifier ? ' + ' + modifier : '') + ' = ' + (result + modifier);
            this.flash(message, 'primary');
        },
    }
}
