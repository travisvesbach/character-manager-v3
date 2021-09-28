<template>
    <grid-section title="Modifiers">
        <template #button>
            <jet-secondary-button size="sm" @click="openModal()">
                Add
            </jet-secondary-button>
        </template>

        <div v-for="modifier in creature.modifiers">
            <div class="flex justify-between">
                <span>
                    {{ modifier.name }}:
                </span>
            </div>

            <div class="ml-2">
                <jet-secondary-button size="xs" @click="openModal(modifier)">
                    edit
                </jet-secondary-button>
            </div>
        </div>

        <!-- modifier modal -->
        <jet-dialog-modal :show="show_modal" type="form" max-width="md" @close="closeModal" @submitted="saveModifier">
            <template #header>
                {{ form.name ? 'Edit' : 'New' }} Resource
            </template>

            <template #content>

                <div class="grid grid-cols-1 sm:grid-cols-2">
                    <div class="col-span-1 px-1">
                        <!-- name -->
                        <jet-label for="name" value="Name"/>
                        <jet-input type="text" id="name" class="mt-1 w-full" v-model="form.name" required/>
                        <jet-input-error :message="form.errors.name" class="mt-2"/>
                    </div>

                    <div class="mt-4 col-span-1 sm:col-span-2 grid grid-cols-1 sm:grid-cols-2">

                        <div class="px-1 col-span-1">
                            <jet-label value="Modifier Types"/>
                        </div>

                        <div  class="px-1 col-span-1">
                            <div>
                                <jet-checkbox id="ability" v-model:checked="form.ability"/>
                                <jet-label class="inline-block ml-1" for="ability" value="Ability"/>
                                <jet-input-error :message="form.errors.ability" class="mt-2"/>
                            </div>

                            <div>
                                <jet-checkbox id="save" v-model:checked="form.save"/>
                                <jet-label class="inline-block ml-1" for="save" value="Save"/>
                                <jet-input-error :message="form.errors.save" class="mt-2"/>
                            </div>

                            <div>
                                <jet-checkbox id="attack" v-model:checked="form.attack"/>
                                <jet-label class="inline-block ml-1" for="attack" value="Attack"/>
                                <jet-input-error :message="form.errors.attack" class="mt-2"/>
                            </div>

                            <div>
                                <jet-checkbox id="critial_range" v-model:checked="form.critial_range"/>
                                <jet-label class="inline-block ml-1" for="critial_range" value="Critical Range"/>
                                <jet-input-error :message="form.errors.critial_range" class="mt-2"/>
                            </div>

                            <div>
                                <jet-checkbox id="damage" v-model:checked="form.damage"/>
                                <jet-label class="inline-block ml-1" for="damage" value="Damage"/>
                                <jet-input-error :message="form.errors.damage" class="mt-2"/>
                            </div>
                        </div>
                    </div>

                <div class="px-1 col-span-1 sm:col-span-2 mt-4" v-if="form.ability">
                    <!-- ability dice -->
                    <jet-label for="ability_dice" value="Ability Modifier"/>
                    <dice-array-input v-model="form.ability_dice"/>
                    <jet-input-error :message="form.errors.ability_dice" class="mt-2"/>
                </div>

                <div class="px-1 col-span-1 sm:col-span-2 mt-4" v-if="form.save">
                    <!-- save dice -->
                    <jet-label for="save_dice" value="Save Modifier"/>
                    <dice-array-input v-model="form.save_dice"/>
                    <jet-input-error :message="form.errors.save_dice" class="mt-2"/>
                </div>

                <div class="px-1 col-span-1 sm:col-span-2 mt-4" v-if="form.attack">
                    <!-- attack dice -->
                    <jet-label for="attack_dice" value="Attack Modifier"/>
                    <dice-array-input v-model="form.attack_dice"/>
                    <jet-input-error :message="form.errors.attack_dice" class="mt-2"/>
                </div>

                <div class="px-1 col-span-1 sm:col-span-2 mt-4" v-if="form.critial_range">
                    <!-- critical hit range  -->
                    <jet-label for="critial_range_start" value="Critial Hit Range"/>
                    <jet-input type="number" class="mt-1 w-14" v-model.number="form.critial_range_start"/> - 20
                    <jet-input-error :message="form.errors.critial_range_start" class="mt-2"/>
                </div>


        <!--
            'damage_as',
            'damage_dc',
            'damage_save',
            'damage_dice',
        -->


                </div>

                <div v-if="form.type == 'dice'" class="px-1">
                    <!-- dice -->
                    <jet-label for="dice" value="Dice" class="mt-4"/>
                    <dice-array-input v-model="form.dice" :current="true" :multiple="true"/>
                    <jet-input-error :message="form.errors.dice" class="mt-2"/>
                </div>
            </template>

            <template #footerend>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
    import JetInputError from '@/Jetstream/InputError'
    import SelectInput from '@/Components/SelectInput'
    import DiceArrayInput from '@/Components/DiceArrayInput'
    import CounterSlot from '@/Components/CounterSlot'
    import GridSection from '@/Components/GridSection'
    import JetCheckbox from '@/Jetstream/Checkbox'

    import { flash } from '@/Mixins/Flash';

    export default {
        props: ['creature', 'type'],
        components: {
            JetButton,
            JetSecondaryButton,
            JetDialogModal,
            JetLabel,
            JetInput,
            JetInputError,
            SelectInput,
            DiceArrayInput,
            CounterSlot,
            GridSection,
            JetCheckbox,
        },
        mixins: [flash],
        data() {
            return {
                show_modal: false,
                form: this.$inertia.form({}),
            };
        },
        methods: {
            setForm(modifier = null) {
                if(modifier) {
                    this.form = this.$inertia.form({
                        id: modifier.id,
                        name: modifier.name,
                        creature_id: modifier.creature_id,
                        creature_type: modifier.creature_type,
                        ability: modifier.ability,
                        ability_dice: modifier.ability_dice,
                        save: modifier.save,
                        save_dice: modifier.save_dice,
                        attack: modifier.attack,
                        attack_dice: modifier.attack_dice,
                        critical_range: modifier.critical_range,
                        critical_range_start: modifier.critical_range_start,
                        damage: modifier.damage,
                        damage_as: modifier.damage_as,
                        damage_dc: modifier.damage_dc,
                        damage_save: modifier.damage_save,
                        damage_dice: modifier.damage_dice,
                        editing: true,
                    });
                } else {
                    this.form = this.$inertia.form({
                        id: null,
                        name: null,
                        creature_id: this.creature.id,
                        creature_type: 'App\\Models\\'+this.type,
                        ability: false,
                        ability_dice: [{
                            count: 0,
                            size: 0,
                            modifier: 0,
                        }],
                        save: false,
                        save_dice: [{
                            count: 0,
                            size: 0,
                            modifier: 0,
                        }],
                        attack: false,
                        attack_dice: [{
                            count: 0,
                            size: 0,
                            modifier: 0,
                        }],
                        critical_range: false,
                        critical_range_start: null,
                        damage: false,
                        damage_as: null,
                        damage_dc: null,
                        damage_save: null,
                        damage_dice: [{
                            count: 0,
                            size: 0,
                            modifier: 0,
                            type: null,
                        }],
                    });
                }
            },
            openModal(modifier = null) {
                this.setForm(modifier);
                this.show_modal = true;
            },
            closeModal() {
                this.show_modal = false;
            },
            saveModifier() {
                if(this.form.editing) {
                    this.form.patch(route('modifiers.update', this.form.id), {
                        onSuccess: (response) => {
                            this.closeModal();
                        }
                    });
                } else {
                    this.form.post(route('modifiers.store'), {
                        onSuccess: (response) => {
                            this.closeModal();
                        }
                    });
                }
            },
        }
    }
</script>
