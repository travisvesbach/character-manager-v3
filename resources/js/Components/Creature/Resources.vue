<template>
    <grid-section title="Resources">
        <template #button>
            <jet-secondary-button size="sm" @click="openModal()" v-if="ownerOrAdmin">
                Add
            </jet-secondary-button>
        </template>

        <div :class="index != 0 ? 'my-1' : 'mb-1'" v-for="(resource, index) in creature.resources">
            <div class="flex justify-between">
                <button class="btn-text" @click="openModal(resource)" :title="disabled ? '' : 'Edit resource'" :disabled="!ownerOrAdmin">
                    {{ resource.name }}:
                </button>
                <span v-if="resource.type == 'counter' && resource.counter_type == 'slots'">
                    <counter-slot v-for="(slot, index) in resource.slots" :slot="slot" @click.native="updateSlot(resource, index)" :disabled="disabled"/>
                </span>
                <span v-if="resource.type == 'counter' && resource.counter_type == 'points'">
                    <jet-input type="number" class="w-16 p-1" v-model.number="resource.current" @input="updateCreature" v-if="!disabled"/> <span v-if="!disabled">/</span> {{ resource.total }}
                </span>
                <jet-secondary-button size="xs" class="ml-auto inline-block" @click="rollDice(resource)" v-if="resource.type == 'dice'" :disabled="disabled">
                    <span v-for="(dice, index) in resource.dice" :class="index > 0 ? 'ml-1' : ''">
                        {{ dice.count }}d{{ dice.size }}{{ dice.modifier ? '+' + dice.modifier : '' }}
                    </span>
                </jet-secondary-button>
                <jet-secondary-button size="xs" class="ml-auto inline-block" @click="rollTable(resource.dice_table)" v-if="resource.type == 'dice table'" :disabled="disabled">
                    Roll
                </jet-secondary-button>
            </div>
        </div>

        <!-- resource modal -->
        <jet-dialog-modal :show="show_modal" type="form" max-width="md" @close="closeModal" @submitted="saveModal">
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

                    <div class="col-span-1 px-1 mt-4 sm:mt-0">
                        <!-- type -->
                        <jet-label for="type" value="Type"/>
                        <select-input id="type" class="mt-1 w-full" v-model="form.type" :options="['counter', 'dice', 'dice table']" required/>
                        <jet-input-error :message="form.errors.type" class="mt-2"/>
                    </div>
                </div>

                <div v-if="form.type == 'counter'">
                    <div class="grid grid-cols-1 sm:grid-cols-2">
                        <div class="col-span-1 px-1">
                            <!-- counter_type -->
                            <jet-label for="counter_type" value="Counter Type" class="mt-4"/>
                            <select-input id="counter_type" class="mt-1 w-full" v-model="form.counter_type" :options="[['points', 'Points'], ['slots', 'Slots']]" required/>
                            <jet-input-error :message="form.errors.counter_type" class="mt-2"/>
                        </div>

                        <div class="col-span-1 px-1">
                            <!-- total -->
                            <jet-label for="total" value="Total" class="mt-4"/>
                            <jet-input type="number" id="total" class="mt-1 w-full" v-model.number="form.total" required/>
                            <jet-input-error :message="form.errors.total" class="mt-2"/>
                        </div>

                        <div class="col-span-1 px-1">
                            <!-- recover -->
                            <jet-label for="recover" value="Recover" class="mt-4"/>
                            <select-input id="recover" class="mt-1 w-full" v-model="form.recover" :options="[['', 'None'], ['short', 'Short Rest'], ['long', 'Long Rest']]"/>
                            <jet-input-error :message="form.errors.recover" class="mt-2"/>
                        </div>
                    </div>
                </div>

                <div v-if="form.type == 'dice'" class="px-1">
                    <!-- dice -->
                    <jet-label for="dice" value="Dice" class="mt-4"/>
                    <dice-array-input v-model="form.dice" :current="true" :multiple="true"/>
                    <jet-input-error :message="form.errors.dice" class="mt-2"/>
                </div>

                <div v-if="form.type == 'dice table'" class="px-1">
                    <!-- dice_table_id -->
                    <jet-label for="dice_table_id" value="Dice Table" class="mt-4"/>
                    <select-input class="w-full" v-model="form.dice_table_id" :options="diceTableOptions"/>
                    <jet-input-error :message="form.errors.dice_table_id" class="mt-2"/>
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
                Are you sure you want to delete this resource?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="show_delete_modal = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteResource" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Resource
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

    </grid-section>
</template>

<script>
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetLabel from '@/Jetstream/Label'
    import JetInputError from '@/Jetstream/InputError'
    import SelectInput from '@/Components/SelectInput'
    import DiceArrayInput from '@/Components/DiceArrayInput'
    import GridSection from '@/Components/GridSection'

    import { CreatureResources } from '@/Mixins/Creature/Resources'
    import { DiceTableRoll } from '@/Mixins/DiceTableRoll'

    export default {
        components: {
            JetDangerButton,
            JetDialogModal,
            JetConfirmationModal,
            JetLabel,
            JetInputError,
            SelectInput,
            DiceArrayInput,
            GridSection,
        },
        mixins: [CreatureResources, DiceTableRoll],
        data() {
            return {
                show_modal: false,
                show_delete_modal: false,
                dice_tables: null,
            };
        },
        computed: {
            diceTableOptions() {
                let options = [];
                if(this.dice_tables) {
                    this.dice_tables.forEach(table => {
                        options.push([table.id, table.name]);
                    });
                }
                return options;
            }
        },
        methods: {
            openModal(resource = null) {
                this.setForm(resource);
                this.show_modal = true;
                this.getDiceTables();
            },
            closeModal() {
                this.show_modal = false;
            },
            saveModal() {
                this.form.current = this.form.total;
                if(this.form.type == 'counter') {
                    this.form.slots = [];
                    for(let j=0; j < this.form.total; j++) {
                        this.form.slots.push(false);
                    }
                }
                this.saveResource();
            },
            deleteResource() {
                this.form.delete(route('resources.destroy', this.form.id));
                this.closeModal();
                this.show_delete_modal = false;
            },
            getDiceTables() {
                axios.get(route('dice_tables.select_list')).then((response) => {
                    console.log(response.data);
                    this.dice_tables = response.data;
                });
            }
        }
    }
</script>
