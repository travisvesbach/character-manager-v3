<template>
    <grid-section title="Spells">
        <template #button>
            <jet-secondary-button size="sm" @click="openModal" v-if="creature.spell_list_type == 'prepared'">
                Prepare
            </jet-secondary-button>
        </template>

        <p>Save DC: {{ creature.spell_dc }}</p>

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


        <!-- prepare spells modal -->
        <jet-dialog-modal :show="model_show" @close="closeModal">
            <template #header>
                Prepared Spells
            </template>

            <template #content>
                <p class="text-lg">{{ preparedCount }} out of {{ creature.spell_prepare_count }} prepared</p>
                <div v-for="(num, index) in 10">
                    <div class="border-t dark:border-gray-600 pt-2" v-if="index != 0 && creature['spell_list_' + index] && creature['spell_list_' + index].length > 0">
                        <p><strong>{{ ordinalSuffix(index) }}</strong></p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                            <label class="col-span-1 py-1" :class="preparedCount == creature.spell_prepare_count && !prepared_spells.includes(spell) ? 'opacity-50' : ''" v-for="spell in creature['spell_list_' + index]">
                                <input type="checkbox" v-model="prepared_spells" :value="spell" :disabled="preparedCount == creature.spell_prepare_count && !prepared_spells.includes(spell)"/> {{ spell }}
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #footerend>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="savePrepared">
                    Save
                </jet-button>
            </template>
        </jet-dialog-modal>
    </grid-section>
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
    import GridSection from '@/Components/GridSection'

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
            GridSection,
        },
        mixins: [flash, creatureEmit],
        data() {
            return {
                accordion_key: 0,
                model_show: false,
                spell_point_costs: [2,3,5,6,7,9,10,11,13],
                form: {},
                prepared_spells: [],
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
                                list.push([i, level_list]);
                            } else if(this.creature.spell_prepared) {
                                let common = level_list.filter(value => this.creature.spell_prepared.includes(value));
                                if(common.length > 0) {
                                    list.push([i, common]);
                                }
                            }
                        }
                    }
                    this.accordion_key++;
                }
                return list;
            },
            preparedCount() {
                return this.prepared_spells ? this.prepared_spells.length : 0;
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
                this.prepared_spells = this.creature.spell_prepared || [];
                this.model_show = true;
            },
            closeModal() {
                this.model_show = false;
            },
            savePrepared() {
                this.creature.spell_prepared = this.prepared_spells;
                this.updateCreature();
                this.closeModal();
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


