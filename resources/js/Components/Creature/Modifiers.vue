<template>
    <grid-section title="Modifiers">
        <template #button>
            <jet-secondary-button size="sm" @click="openModal()" v-if="ownerOrAdmin">
                Add
            </jet-secondary-button>
        </template>

        <div class="flex justify-between" :class="index != 0 ? 'my-1' : 'mb-1'" v-for="(modifier, index) in creature.modifiers">
            <button class="btn-text" :title="disabled ? '' : 'Edit modifier'" @click="openModal(modifier)" :disabled="!ownerOrAdmin">
                {{ modifier.name }}
            </button>
            <jet-checkbox :id="'enable_' + modifier.name" :class="disabled ? 'hidden' : ''" v-model:checked="modifier.enabled" @change.native="toggleEnabled(modifier)"/>
        </div>

        <!-- modifier modal -->
        <jet-dialog-modal :show="show_modal" type="form" max-width="xl" @close="closeModal" @submitted="saveModifier">
            <template #header>
                {{ form.name ? 'Edit' : 'New' }} Modifier
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
                            <jet-input-error :message="form.errors.types" class="mt-2"/>
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
                                <jet-checkbox id="critical_range" v-model:checked="form.critical_range"/>
                                <jet-label class="inline-block ml-1" for="critical_range" value="Critical Range"/>
                                <jet-input-error :message="form.errors.critical_range" class="mt-2"/>
                            </div>

                            <div>
                                <jet-checkbox id="damage" v-model:checked="form.damage"/>
                                <jet-label class="inline-block ml-1" for="damage" value="Damage"/>
                                <jet-input-error :message="form.errors.damage" class="mt-2"/>
                            </div>
                        </div>
                    </div>

                    <div class="px-1 col-span-1 sm:col-span-2 mt-4 pt-2 border-t dark:border-gray-600" v-if="form.ability">
                        <!-- ability dice -->
                        <jet-label for="ability_dice" value="Ability Modifier"/>
                        <dice-array-input v-model="form.ability_dice"/>
                        <jet-input-error :message="form.errors.ability_dice" class="mt-2"/>
                    </div>

                    <div class="px-1 col-span-1 sm:col-span-2 mt-4 pt-2 border-t dark:border-gray-600" v-if="form.save">
                        <!-- save dice -->
                        <jet-label for="save_dice" value="Save Modifier"/>
                        <dice-array-input v-model="form.save_dice"/>
                        <jet-input-error :message="form.errors.save_dice" class="mt-2"/>
                    </div>

                    <div class="px-1 col-span-1 sm:col-span-2 mt-4 pt-2 border-t dark:border-gray-600" v-if="form.attack">
                        <!-- attack dice -->
                        <jet-label for="attack_dice" value="Attack Modifier"/>
                        <dice-array-input v-model="form.attack_dice"/>
                        <jet-input-error :message="form.errors.attack_dice" class="mt-2"/>
                    </div>

                    <div class="px-1 col-span-1 sm:col-span-2 mt-4 pt-2 border-t dark:border-gray-600" v-if="form.critical_range">
                        <!-- critical hit range  -->
                        <jet-label for="critical_range_start" value="Critial Hit Range"/>
                        <jet-input type="number" class="mt-1 w-14" v-model.number="form.critical_range_start"/> - 20
                        <jet-input-error :message="form.errors.critical_range_start" class="mt-2"/>
                    </div>

                    <div class="px-1 col-span-1 sm:col-span-2 mt-4 pt-2 border-t dark:border-gray-600" v-if="form.damage">
                        <!-- damage_as  -->
                        <jet-label for="damage_as" value="Damage Added As"/>
                        <select-input class="mt-1" v-model="form.damage_as" :options="[['attack', 'Part of the Attack'], ['save', 'Save']]"/>
                        <jet-input-error :message="form.errors.damage_as" class="mt-2"/>

                        <div class="grid grid-cols-1 sm:grid-cols-2" v-if="form.damage_as == 'save'">
                            <div class="col-span-1 mt-4">
                                <!-- damage_dc  -->
                                <jet-label for="damage_dc" value="Save DC"/>
                                <jet-input type="number" class="mt-1 w-14" v-model.number="form.damage_dc"/>
                                <jet-input-error :message="form.errors.damage_dc" class="mt-2"/>
                            </div>

                            <div class="col-span-1 mt-4">
                                <!-- damage_save  -->
                                <jet-label for="damage_save" value="Save DC"/>
                                <select-input class="mt-1" v-model="form.damage_save" :options="['STR', 'DEX', 'CON', 'INT', 'WIS', 'CHA']"/>
                                <jet-input-error :message="form.errors.damage_save" class="mt-2"/>
                            </div>
                        </div>

                        <!-- damage_dice -->
                        <jet-label for="damage_dice" value="Damage" class="mt-4"/>
                        <dice-array-input v-model="form.damage_dice" :multiple="true" :same="true"/>
                        <jet-input-error :message="form.errors.damage_dice" class="mt-2"/>
                    </div>

                    <div class="px-1 col-span-1 sm:col-span-2 mt-4 pt-2 border-t dark:border-gray-600">
                        <jet-label for="notes" value="Notes"/>
                        <textarea id="notes" class="w-full form-input" v-model="form.notes"></textarea>
                        <jet-input-error :message="form.errors.notes" class="mt-2"/>
                    </div>
                </div>
            </template>

            <template #footer>
                <jet-danger-button @click="show_delete_modal = true" v-if="form.editing">
                    Delete
                </jet-danger-button>
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

        <!-- delete confirmation -->
        <jet-confirmation-modal :show="show_delete_modal" @close="show_delete_modal = false">
            <template #title>
                Delete {{ form.name }}
            </template>

            <template #content>
                Are you sure you want to delete this modifier?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="show_delete_modal = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteModifier" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Modifier
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </grid-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetLabel from '@/Jetstream/Label'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import SelectInput from '@/Components/SelectInput'
    import DiceArrayInput from '@/Components/DiceArrayInput'
    import CounterSlot from '@/Components/CounterSlot'
    import GridSection from '@/Components/GridSection'
    import JetCheckbox from '@/Jetstream/Checkbox'

    import { CreatureComponent } from '@/Mixins/CreatureComponent';

    export default {
        components: {
            JetButton,
            JetSecondaryButton,
            JetDangerButton,
            JetDialogModal,
            JetConfirmationModal,
            JetLabel,
            JetInput,
            JetInputError,
            SelectInput,
            DiceArrayInput,
            CounterSlot,
            GridSection,
            JetCheckbox,
        },
        mixins: [CreatureComponent],
        data() {
            return {
                show_modal: false,
                show_delete_modal: false,
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
                        notes: modifier.notes,
                        enabled: modifier.enabled,
                        no_alert: false,
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
                        notes: null,
                        enabled: false,
                        no_alert: false,
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
            saveModifier(no_alert = false) {
                if(this.form.ability == false && this.form.save == false && this.form.attack == false && this.form.critical_range == false && this.form.damage == false) {
                    this.form.errors.types = 'required';
                    return;
                } else {
                    this.form.errors.types = null;
                }

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
            toggleEnabled(modifier) {
                this.setForm(modifier);
                this.form.enabled = modifier.enabled;
                this.form.no_alert = true;
                this.saveModifier();
            },
            deleteModifier() {
                this.form.delete(route('modifiers.destroy', this.form.id));
                this.closeModal();
                this.show_delete_modal = false;
            },
        }
    }
</script>
