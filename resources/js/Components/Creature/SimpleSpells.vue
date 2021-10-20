<template>
    <div class="border-t border-color pt-1 mt-1">
        <div class="flex items-center">
            <span>
                Save DC: {{ creature.spell_dc }}
            </span>

            <span class="ml-auto" v-if="creature.spell_type == 'points'">
                Points:
                <jet-input type="number" class="w-10 text-sm p-1" :class="disabled ? 'hidden' : ''" v-model.number="creature.spell_points_current" @change="usePoints();"/>
                <span :class="disabled ? 'hidden' : ''">/</span> {{creature.spell_points_max}}
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-2 lg:grid-cols-3" v-if="creature.spell_type == 'slots'">
            <div class="col-span1" v-for="level in 9">
                <span v-if="creature['spell_slots_' + level] && creature['spell_slots_' + level].length > 0">
                    {{ level }}:
                    <counter-slot v-for="(slot, index) in creature['spell_slots_' + level]" :slot="slot" @click.native="updateSlot(level, index)" :disabled="disabled"/>
                </span>
            </div>
        </div>

        <div v-if="creature.spell_type == 'points'">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-2 lg:grid-cols-3">
                <div v-for="(cost, index) in spell_point_costs_available">
                    <button class="btn-text" @click="usePoints(cost)" :disabled="disabled">
                        {{index+1}}: {{cost}} points
                    </button>
                </div>
            </div>
        </div>

        <accordion :key="accordion_key">
            <accordion-item :id="'list_' + index + '_accordion'" class="mt-2" v-for="(list, index) in filteredSpellLists" v-if="filteredSpellLists.length > 0" :key="index">
                <template v-slot:title>
                    {{ list[0] == 0 ? 'Cantrips' : ordinalSuffix(list[0]) + ' Level' }}:
                </template>
                <template v-slot:content>
                    <ul class="ml-2">
                        <li v-for="spell in list[1]">
                            {{spell}}
                        </li>
                    </ul>
                </template>
            </accordion-item>
        </accordion>
    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetInput from '@/Jetstream/Input'
    import Accordion from '@/Components/Accordion'
    import AccordionItem from '@/Components/AccordionItem'
    import CounterSlot from '@/Components/CounterSlot'

    import { Flash } from '@/Mixins/Flash';
    import { CreatureBase } from '@/Mixins/Creature/Base';
    import { CreatureSpells } from '@/Mixins/Creature/Spells';

    export default {
        components: {
            JetButton,
            JetSecondaryButton,
            JetInput,
            Accordion,
            AccordionItem,
            CounterSlot,
        },
        mixins: [Flash, CreatureBase, CreatureSpells],
    }
</script>


