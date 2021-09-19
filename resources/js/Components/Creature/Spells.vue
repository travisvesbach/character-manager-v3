<template>
    <div class="col-span-1 border dark:border-gray-700">
        <div class="p-2 flex justify-between">
            <h3 class="text-xl">Spells</h3>
            <jet-secondary-button :small="true" @click="openModal">
                Edit
            </jet-secondary-button>
        </div>
         <div class="px-2 p-1 bg-gray-50 border-t dark:bg-gray-800 dark:border-gray-700">
            <div>Spell Save DC: {{ creature.spell_dc }}</div>

            <div v-if="creature.spell_type == 'slots'">
                <div v-for="level in 9">
                    <span v-if="creature['spell_slots_' + level] && creature['spell_slots_' + level].length > 0">
                        {{ level }}:
                        <counter-slot v-for="(slot, index) in creature['spell_slots_' + level]" :slot="slot" @click.native="updateSlot(level, index)"/>
                    </span>
                </div>
            </div>

            <div v-if="creature.spell_type == 'points'">
                <div>
                    Points:
                    <jet-input type="number" class="w-14" v-model.number="creature.spell_points_current" @change="usePoints();"/>
                    / {{creature.spell_points_max}}
                </div>
                <div v-for="(cost, level) in spell_point_costs">
                    <button v-if="level != 0 && level <= creature.spell_level" @click="usePoints(cost)">
                        {{level}}: {{cost}} points
                    </button>
                </div>
            </div>

            <accordion :key="accordion_key">
                <accordion-item :id="'list_' + index + '_accordion'" class="mt-2" v-for="(list, index) in filteredSpellLists" v-if="filteredSpellLists.length > 0" :key="index">
                    <template v-slot:title>
                        {{ index == 0 ? 'Cantrips' : ordinalSuffix(index) + ' Level' }}:
                    </template>
                    <template v-slot:content>
                        <ul class="ml-2">
                            <li v-for="spell in list">
                                {{spell}}
                            </li>
                        </ul>
                    </template>
                </accordion-item>
            </accordion>
         </div>


        <!-- edit spells modal -->
        <jet-dialog-modal :show="spells_modal" @close="closeModal">
            <template #header>
                Edit Spells
            </template>

            <template #content>

            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="saveSpells">
                    Save
                </jet-button>
            </template>
        </jet-dialog-modal>
    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetLabel from '@/Jetstream/Label'
    import JetInput from '@/Jetstream/Input'
    import SelectInput from '@/Components/SelectInput'
    import Accordion from '@/Components/Accordion'
    import AccordionItem from '@/Components/AccordionItem'
    import CounterSlot from '@/Components/CounterSlot'

    import { flash } from '@/Mixins/Flash';
    import { creatureEmit } from '@/Mixins/Creature/Emit';

    export default {
        props: ['creature'],
        components: {
            JetButton,
            JetSecondaryButton,
            JetDialogModal,
            JetLabel,
            JetInput,
            SelectInput,
            Accordion,
            AccordionItem,
            CounterSlot,
        },
        emits: ['updated'],
        mixins: [flash, creatureEmit],
        data() {
            return {
                accordion_key: 0,
                spells_modal: false,
                spell_point_costs: [2,3,5,6,7,9,10,11,13],
                form: {},
            };
        },
        computed: {
            filteredSpellLists() {
                let list = [];
                if(this.creature.spellcaster) {
                    for(let i=0;i<10;i++) {
                        let level_list = this.creature['spell_list_' + i];
                        if(level_list && level_list.length > 0) {
                            if(this.creature.spell_list_type == 'known' || i == 0) {
                                list.push(level_list);
                            } else {
                                let common = checking.creature.filter(value => this.creature.spells_prepared.includes(value));
                                if(common.length > 0) {
                                    list.push(common);
                                }
                            }
                        }
                    }
                    this.accordion_key++;
                }
                return list;
            }
        },
        methods: {
            ordinalSuffix(num) {
                let j = num % 10
                let k = num % 100;
                if (j == 1 && k != 11) {
                    return num + "st";
                }
                if (j == 2 && k != 12) {
                    return num + "nd";
                }
                if (j == 3 && k != 13) {
                    return num + "rd";
                }
                return num + "th";
            },
            openModal() {
                this.spells_modal = true;
            },
            closeModal() {
                this.spells_modal = false;
            },
            updateSlot(level, index) {
                this.creature['spell_slots_' + level][index] = !this.creature['spell_slots_' + level][index];
                this.updateCreature();
            },
            usePoints(cost = null) {
                if (this.creature.spell_points_current >= cost) {
                    this.creature.spell_points_current -= cost;
                } else if(cost != null) {
                    this.flash('Not enough spell points remaining', 'danger');
                }
                this.updateCreature();
            },
        },
    }
</script>


