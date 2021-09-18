<template>
    <div class="col-span-1 border dark:border-gray-700">
        <div class="p-2 flex justify-between">
            <h3 class="text-xl">Spells</h3>
            <jet-secondary-button :small="true" @click="openModal">
                Edit
            </jet-secondary-button>
        </div>
         <div class="px-2 p-1 bg-gray-50 border-t dark:bg-gray-800 dark:border-gray-700">
            <div v-if="!spells || (!spells.spell_type && spells.spell_counters.length == 0)">
                If your {{ type }} is not a spellcaster, you can hide this section by clicking 'Toggle Spells' from the dropdown menu next to the {{ type }}'s name.
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
                <div class="flex">
                    <jet-label class="inline-block w-1/2" for="spell_type">Spellcasting Type:</jet-label>
                    <div class="inline-block">
                        <div>
                            <input class="inline-block" type="radio" name="spell_type" id="no-spells" :value="null" v-model="spells.spell_type">
                            <jet-label class="ml-1 inline-block" for="no-spells">No spellcasting</jet-label>
                        </div>
                        <div>
                            <input class="inline-block" type="radio" name="spell_type" id="yes-spell-slots" value="slots" v-model="spells.spell_type"/>
                            <jet-label class="ml-1 inline-block" for="yes-spell-slots">Slots</jet-label>
                        </div>
                        <div>
                            <input class="inline-block" type="radio" name="spell_type" id="yes-spell-points" value="points" v-model="spells.spell_type">
                            <jet-label class="ml-1 inline-block" for="yes-spell-points">Points (DMG Variant)</jet-label>
                        </div>
                    </div>
                </div>
                <div class="my-2 flex">
                    <jet-label class="inline-block w-1/2" for="spell_dc">Spell DC:</jet-label>
                    <jet-input type="number" id="spell_dc" class="inline-block w-1/2" placeholder="0" v-model.number="spells.spell_dc"/>
                </div>
                <div class="my-2 flex" v-if="spells.spell_type">
                    <jet-label class="inline-block w-1/2" for="recover_on_rest">Recover on a rest:</jet-label>
                    <select-input id="recover_on_rest" class="inline-block" v-model="spells.recover_on_rest" :options="['short', 'long']"/>
                </div>
                <div class="my-2 flex" v-if="spells.spell_type">
                    <jet-label class="inline-block w-1/2" for="spell_list_type">Spellcaster Type:</jet-label>
                    <select-input id="spell_list_type" class="inline-block" v-model="spells.spell_list_type" :options="[['known', 'Known (learn on level up)'], ['prepared', 'Prepared (spellbook or full spell list)']]"/>
                </div>
                <div class="my-2" v-if="spells.spell_type && spell_list_type == 'prepared'">
                    <jet-label for="can_prepare_count">Total number of spells you can prepare:</jet-label>
                    <input class="input-short" type="number" id="can_prepare_count" v-model="spells.can_prepare_count">
                </div>
                <div class="border-t" v-if="spells.spell_type == 'points'">
                    <p class="text-xl">Spell Points</p>
                    <div class="my-2 flex">
                        <jet-label class="inline-block w-1/2" for="spell-points">Total Spell Points:</jet-label>
                        <jet-input type="number" class="input-block" id="spell-points" placeholder="0" v-model.number="max_spell_points"/>
                    </div>
                    <div class="my-2 flex">
                        <jet-label class="inline-block w-1/2" for="max_spell_level">Max Spell Level Avaibale:</jet-label>
                        <jet-input type="number" class="inline-block" id="max_spell_level" placeholder="0" v-model.number="max_spell_level"/>
                    </div>
                </div>
                <div class="border-t" v-if="spells.spell_type == 'slots'">
                    <p class="text-xl">Spell Slots</p>
                    <div class="my-2 grid grid-cols-2 sm:grid-cols-3">
                        <div class="m-2 col-span-1 flex justify-center items-center" v-for="num in 9">
                            <jet-label class="inline-block mr-1" :for="'slots_' + num">{{ ordinalSuffix(num) + ' Level' }}:</jet-label>
                            <jet-input type="number" class="inline-block w-14" :id="'slots_' + num" placeholder="0" v-model.number="spells['slots_' + num]"/>
                        </div>
                    </div>
                </div>
                <div class="border-t" v-if="spells.spell_type">
                    <p class="text-xl">Spell List</p>
                    <p class="my-2">{{spellListExplanation}}</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2">
                        <div class="m-2 col-span-1" v-for="(num, index) in 10">
                            <jet-label :for="'list_' + index">{{ index == 0 ? 'Cantrips' : ordinalSuffix(index) + ' Level' }}:</jet-label>
                            <textarea :id="'list_' + index" class="w-full form-input-color" v-model="spells['list_' + index]" placeholder="Firebolt, Minor Illusion"></textarea>
                        </div>
                    </div>
                </div>
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

    export default {
        props: ['spells_input', 'type'],
        components: {
            JetButton,
            JetSecondaryButton,
            JetDialogModal,
            JetLabel,
            JetInput,
            SelectInput,
            Accordion,
            AccordionItem,
        },
        data() {
            return {
                accordion_key: 0,
                spells_modal: false,
                spellPointsCosts: [0,2,3,5,6,7,9,10,11,13],
                spells: {
                    spell_type: null,
                    spell_dc: null,
                    max_spell_level: null,
                    max_spell_points: null,
                    current_spell_points: null,
                    recover_on_rest: 'long',
                    spell_list_type: 'known',
                    can_prepare_count: null,
                    prepared_spells: [],
                    slots_1: [],
                    slots_2: [],
                    slots_3: [],
                    slots_4: [],
                    slots_5: [],
                    slots_6: [],
                    slots_7: [],
                    slots_8: [],
                    slots_9: [],
                    list_0: [],
                    list_1: [],
                    list_2: [],
                    list_3: [],
                    list_4: [],
                    list_5: [],
                    list_6: [],
                    list_7: [],
                    list_8: [],
                    list_9: [],
                    spell_counters: [],
                },
            };
        },
        computed: {
            spellListExplanation() {
                if(this.spells.spell_list_type == 'known') {
                    return "List all of your known spells below.  Spells should be separated by a comma.";
                } else {
                    return "List all of the spells in your spellbook or class's spell list below.  You will have the option later to select which spells from your list you have prepared and then only show the prepared spells.  Seplls shoudl be separated by a comma.";
                }
            },
            filteredSpellLists() {
                let list = [];
                for(let i=0;i<10;i++) {
                    let level_list = this.spells['list_' + i];
                    if(level_list && level_list.length > 0) {
                        if(this.spells.spell_list_type == 'known' || i == 0) {
                            list.push(level_list);
                        } else {
                            let common = checking.spells.filter(value => this.spells.prepared_spells.includes(value));
                            if(common.length > 0) {
                                list.push(common);
                            }
                        }
                    }
                }
                this.accordion_key++;
                return list;
            }
        },
        created() {
            if(this.spells_input) {
                this.spells = this.spells_input;
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
            joinList(list) {
                if(list != null) {
                    return list.join(', ');
                } else {
                    return '';
                }
            },
            splitList(list) {
                if(list != '') {
                    return list.split(', ').sort();
                } else {
                    return null;
                }
            },
            openModal() {
                for(let i=0;i<10;i++) {
                    this.spells['list_' + i] = this.joinList(this.spells['list_' + i]);
                }
                this.spells_modal = true;
            },
            closeModal() {
                this.spells_modal = false;
                for(let i=0;i<10;i++) {
                    this.spells['list_' + i] = this.splitList(this.spells['list_' + i]);
                }
            },
            saveSpells() {
                this.closeModal();
                this.$emit('updated', this.spells);
            },
        },
    }
</script>


