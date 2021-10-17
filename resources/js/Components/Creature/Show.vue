<template>
    <div>
        <heading :creature="creature" :type="type"/>

        <stats :creature="creature" :type="type"/>

        <div class="grid lg:grid-cols-2">

            <div class="flex flex-col">
                <additional-stats :creature="creature" :type="type" v-if="creature.show_additional_stats"/>

                <actions class="flex-grow" :creature="creature" :type="type"/>

                <dice :creature="creature" :disabled="disabled" v-if="creature.show_dice"/>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-6">
                <modifiers class="lg:col-span-3" :class="getWidth('modifiers')" :creature="creature" :type="type" v-if="creature.show_modifiers"/>

                <resources class="lg:col-span-3" :class="getWidth('resources')" :creature="creature" :type="type" v-if="creature.show_resources"/>

                <spells class="lg:col-span-3 lg:col-span-3" :class="getWidth('spellcaster')" :creature="creature" :type="type" v-if="creature.spellcaster"/>

                <notepad class="lg:col-span-3" :class="getWidth('notes')" :creature="creature" :type="type" v-if="creature.show_notes"/>
            </div>
        </div>
    </div>
</template>

<script>
    import Heading from '@/Components/Creature/Heading'
    import Stats from '@/Components/Creature/Stats'
    import Spells from '@/Components/Creature/Spells'
    import Resources from '@/Components/Creature/Resources'
    import Modifiers from '@/Components/Creature/Modifiers'
    import Actions from '@/Components/Creature/Actions'
    import Notepad from '@/Components/Creature/Notepad'
    import Dice from '@/Components/Dice'
    import AdditionalStats from '@/Components/Creature/AdditionalStats'

    import { CreatureComponent } from '@/Mixins/CreatureComponent';

    export default {
        components: {
            Heading,
            Stats,
            Spells,
            Resources,
            Modifiers,
            Actions,
            Notepad,
            Dice,
            AdditionalStats,
        },
        mixins: [CreatureComponent],
        methods: {
            getWidth(item) {
                let sections = {
                    modifiers: this.creature.show_modifiers,
                    resources: this.creature.show_resources,
                    spellcaster: this.creature.spellcaster,
                    notes: this.creature.show_notes,
                };

                let show_count = 0;
                show_count += sections['modifiers'] ? 1 : 0;
                show_count += sections['resources'] ? 1 : 0;
                show_count += sections['spellcaster'] ? 1 : 0;
                show_count += sections['notes'] ? 1 : 0;

                if(sections[item]) {
                    switch(show_count) {
                        case 1:
                            return 'lg:col-span-6';
                            break;
                        case 2:
                            return 'lg:col-span-3';
                            break;
                        case 3:
                            return item == 'notes' ? 'lg:col-span-6' : 'lg:col-span-3';
                            break;
                        case 4:
                            return 'lg:col-span-3';
                            break;
                    }
                }
            },
        }
    }
</script>
