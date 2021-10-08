<template>
    <grid-section title="Actions">
        <template #button>
            <jet-secondary-button size="sm" @click="openModal()">
                Add
            </jet-secondary-button>
        </template>

        <div class="" :class="index != 0 ? 'my-1' : 'mb-1'" v-for="(action, index) in creature.actions">
            <span class="cursor-pointer" @click="openModal(action)" title="Edit action">
                {{ action.name }}
            </span>
            <span class="border-l-2 dark:border-gray-600 pl-2 ml-2" title="Action type">
                {{ action.type }}
            </span>
            <span v-if="action.attack">
                <span class="border-l-2 dark:border-gray-600 pl-2 ml-2" title="Range">
                    {{ action.range }}
                </span>
                <span class="border-l-2 dark:border-gray-600 pl-2 ml-2" title="Attack modifier">
                    {{ action.attack_modifier > 0 ? '+' : '' }}{{ action.attack_modifier }}
                </span>
                <span class="border-l-2 dark:border-gray-600 pl-2 ml-2" title="Damage">
                    <span v-for="(dice, index) in action.attack_dice">
                        {{ index > 0 ? ' &' : '' }} {{ dice.count }}d{{ dice.size }}{{ dice.modifier ? '+' + dice.modifier : '' }} {{ dice.type }}
                    </span>
                </span>
            </span>
        </div>

        <!-- action modal -->
        <jet-dialog-modal :show="show_modal" type="form" max-width="xl" @close="closeModal" @submitted="saveAction">
            <template #header>
                {{ form.name ? 'Edit' : 'New' }} Action
            </template>

            <template #content>

                <div class="grid grid-cols-1 sm:grid-cols-2">
                    <div class="col-span-1 px-1">
                        <!-- name -->
                        <jet-label for="name" value="Name"/>
                        <jet-input type="text" id="name" class="mt-1 w-full" v-model="form.name" required/>
                        <jet-input-error :message="form.errors.name" class="mt-2"/>
                    </div>

                    <div class="col-span-1 px-1">
                        <!-- type  -->
                        <jet-label for="type" value="Type" class="mt-4 sm:mt-0"/>
                        <select-input class="mt-1" v-model="form.type" :options="['Action', 'Bonus Action', 'Lair Action', 'Legendary Action', 'Reaction']" required/>
                        <jet-input-error :message="form.errors.type" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- range  -->
                        <jet-label for="range" value="Range" class="mt-4"/>
                        <jet-input type="text" id="range" class="mt-1 w-full" v-model="form.range" required/>
                        <jet-input-error :message="form.errors.range" class="mt-2"/>
                    </div>

                    <div class="col-span-1 px-1">
                        <jet-label value="Action Types" class="mt-4 inline-block"/>
                        <jet-input-error :message="form.errors.types" class="ml-2 inline-block"/>

                        <div  class="px-1 col-span-1">
                            <div>
                                <jet-checkbox id="attack" v-model:checked="form.attack" :disabled="form.auto"/>
                                <jet-label class="inline-block ml-1" for="attack" value="Attack Roll"/>
                                <jet-input-error :message="form.errors.attack" class="mt-2"/>
                            </div>

                            <div>
                                <jet-checkbox id="save" v-model:checked="form.save"/>
                                <jet-label class="inline-block ml-1" for="save" value="Save"/>
                                <jet-input-error :message="form.errors.save" class="mt-2"/>
                            </div>

                            <div>
                                <jet-checkbox id="auto" v-model:checked="form.auto" :disabled="form.attack"/>
                                <jet-label class="inline-block ml-1" for="auto" value="Auto Hit"/>
                                <jet-input-error :message="form.errors.auto" class="mt-2"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-1 sm:col-span-2 mt-4" v-if="form.attack">
                        <div class="grid grid-cols-1 sm:grid-cols-2">
                            <div class="col-span-1 px-1">
                                <!-- attack_modifier -->
                                <jet-label for="attack_modifier" value="Attack Modifier"/>
                                <jet-input type="number" id="attack_modifier" class="mt-1 w-full" v-model.number="form.attack_modifier"/>
                                <jet-input-error :message="form.errors.attack_modifier" class="mt-2"/>
                            </div>
                            <div class="col-span-1 px-1 mt-4 sm:mt-0">
                                <!-- attack_does_damage -->
                                <jet-label for="attack_does_damage" value="Does Damage"/>
                                <jet-checkbox id="attack_does_damage" v-model:checked="form.attack_does_damage"/>
                                <jet-input-error :message="form.errors.attack_does_damage" class="mt-2"/>
                            </div>
                        </div>
                        <div v-if="form.attack_does_damage">
                            <!-- attack_dice -->
                            <jet-label for="attack_dice" value="Damage" class="mt-4"/>
                            <dice-array-input v-model="form.attack_dice" :multiple="true"/>
                            <jet-input-error :message="form.errors.attack_dice" class="mt-2"/>
                        </div>
                    </div>

                    <div class="px-1 col-span-1 sm:col-span-2 mt-4" v-if="form.save">

                    </div>

                    <div class="px-1 col-span-1 sm:col-span-2 mt-4" v-if="form.auto">

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
                Are you sure you want to delete this action?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="show_delete_modal = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteAction" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Action
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

    import { flash } from '@/Mixins/Flash';

    export default {
        props: ['creature', 'type'],
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
        mixins: [flash],
        data() {
            return {
                show_modal: false,
                show_delete_modal: false,
                form: this.$inertia.form({}),
            };
        },
        methods: {
            setForm(action = null) {
                if(action) {
                    this.form = this.$inertia.form({
                        id: action.id,
                        name: action.name,
                        creature_id: action.creature_id,
                        creature_type: action.creature_type,
                        type: action.type,
                        range: action.range,
                        notes: action.notes,
                        attack: action.attack,
                        attack_modifier: action.attack_modifier,
                        attack_does_damage: action.attack_does_damage,
                        attack_dice: JSON.parse(JSON.stringify(action.attack_dice)),
                        save: action.save,
                        save_type: action.save_type,
                        save_dc: action.save_dc,
                        save_does_damage: action.save_does_damage,
                        save_dice: JSON.parse(JSON.stringify(action.save_dice)),
                        auto: action.auto,
                        auto_does_damage: action.auto_does_damage,
                        auto_dice: JSON.parse(JSON.stringify(action.auto_dice)),
                        editing: true,
                    });
                } else {
                    this.form = this.$inertia.form({
                        id: null,
                        name: null,
                        creature_id: this.creature.id,
                        creature_type: 'App\\Models\\'+this.type,
                        type: 'Action',
                        range: null,
                        notes: null,
                        attack: false,
                        attack_modifier: null,
                        attack_does_damage: false,
                        attack_dice: [{
                            count: 0,
                            size: 0,
                            modifier: 0,
                            type: null,
                        }],
                        save: false,
                        save_type: null,
                        save_dc: null,
                        save_does_damage: false,
                        save_dice: [{
                            count: 0,
                            size: 0,
                            modifier: 0,
                            type: null,
                        }],
                        auto: false,
                        auto_does_damage: false,
                        auto_dice: [{
                            count: 0,
                            size: 0,
                            modifier: 0,
                            type: null,
                        }]
                    });
                }
            },
            openModal(action = null) {
                this.setForm(action);
                this.show_modal = true;
            },
            closeModal() {
                this.show_modal = false;
            },
            saveAction() {
                if(this.form.attack == false && this.form.save == false && this.form.auto == false) {
                    this.form.errors.types = 'required';
                    return;
                } else {
                    this.form.errors.types = null;
                }

                if(this.form.editing) {
                    this.form.patch(route('actions.update', this.form.id), {
                        onSuccess: (response) => {
                            this.closeModal();
                        }
                    });
                } else {
                    this.form.post(route('actions.store'), {
                        onSuccess: (response) => {
                            this.closeModal();
                        }
                    });
                }
            },
            deleteAction() {
                this.form.delete(route('actions.destroy', this.form.id));
                this.closeModal();
                this.show_delete_modal = false;
            },
        }
    }
</script>
