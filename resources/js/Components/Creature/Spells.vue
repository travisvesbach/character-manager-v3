<template>
    <grid-section title="Spells">
        <template #button>
            <jet-secondary-button size="sm" @click="openModal" v-if="ownerOrAdmin && creature.spell_list_type == 'prepared'">
                Prepare
            </jet-secondary-button>
        </template>

        <p>Save DC: {{ creature.spell_dc }}</p>

        <div v-if="creature.spell_type == 'slots'">
            <div v-for="level in 9">
                <span v-if="creature['spell_slots_' + level] && creature['spell_slots_' + level].length > 0">
                    {{ level }}:
                    <counter-slot v-for="(slot, index) in creature['spell_slots_' + level]" :slot="slot" @click.native="updateSlot(level, index)" :disabled="disabled"/>
                </span>
            </div>
        </div>

        <div v-if="creature.spell_type == 'points'">
            <div>
                Points:
                <jet-input type="number" class="w-14" :class="disabled ? 'hidden' : ''" v-model.number="creature.spell_points_current" @change="usePoints();"/>
                <span :class="disabled ? 'hidden' : ''">/</span> {{creature.spell_points_max}}
            </div>
            <div v-for="(cost, index) in spell_point_costs_available">
                <button class="btn-text" @click="usePoints(cost)" :disabled="disabled">
                    {{index+1}}: {{cost}} points
                </button>
            </div>
        </div>

        <accordion>
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

    import { Flash } from '@/Mixins/Flash';
    import { CreatureBase } from '@/Mixins/Creature/Base';
    import { CreatureSpells } from '@/Mixins/Creature/Spells';

    export default {
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
        mixins: [Flash, CreatureBase, CreatureSpells],
        data() {
            return {
                accordion_key: 0,
                model_show: false,
                prepared_spells: [],
            };
        },
        computed: {
            preparedCount() {
                return this.prepared_spells ? this.prepared_spells.length : 0;
            }
        },
        methods: {
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
        },
    }
</script>


