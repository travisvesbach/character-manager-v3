<template>
    <div class="col-span-1 border dark:border-gray-700">
        <div class="p-2 flex justify-between">
            <h3 class="text-xl">Resources</h3>
            <jet-secondary-button :small="true" @click="openModal()">
                Add
            </jet-secondary-button>
        </div>
        <div class="px-2 p-1 bg-gray-50 border-t dark:bg-gray-800 dark:border-gray-700">

            <div v-for="resource in creature.resources">

                {{ resource.name }}

                <jet-secondary-button :small="true" @click="openModal(resource)">
                    edit
                </jet-secondary-button>

            </div>



        </div>



        <!-- resource modal -->
        <jet-dialog-modal :show="show_modal" type="form" max-width="md" @close="closeModal" @submitted="saveResource">
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
                        <select-input id="type" class="mt-1 w-full" v-model="form.type" :options="['counter', 'dice']" required/>
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
                    <dice-array-input v-model="form.dice" :current="true"/>
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

    </div>
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

    import { flash } from '@/Mixins/Flash';
    import { creatureEmit } from '@/Mixins/Creature/Emit';

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
        },
        mixins: [flash, creatureEmit],
        data() {
            return {
                show_modal: false,
                form: this.$inertia.form({}),
            };
        },
        methods: {
            resetForm() {
                this.form = this.$inertia.form({
                    id: null,
                    name: null,
                    creature_id: this.creature.id,
                    creature_type: 'App\\Models\\'+this.type,
                    type: null,
                    total: null,
                    counter_type: 'slots',
                    slots: null,
                    current: null,
                    recover: '',
                    dice: [{
                        count: null,
                        size: null,
                        modifier: null,
                    }],
                });
            },
            openModal(resource = null) {
                // this.prepared_spells = this.creature.spell_prepared || [];
                if(resource) {
                    this.form = this.$inertia.form({
                        id: resource.id,
                        name: resource.name,
                        creature_id: resource.creature_id,
                        creature_type: resource.creature_type,
                        type: resource.type,
                        total: resource.total,
                        counter_type: resource.counter_type,
                        slots: resource.slots,
                        current: resource.current,
                        recover: resource.recover,
                        dice: resource.dice,
                        editing: true,
                    });
                } else {
                    this.resetForm();
                }
                this.show_modal = true;
            },
            closeModal() {
                this.show_modal = false;
            },
            saveResource() {
                this.form.current = this.form.total;
                if(this.form.editing) {
                    this.form.patch(route('resources.update', this.form.id), {
                        onSuccess: (response) => {
                            this.closeModal();
                        }
                    });
                } else {
                    this.form.post(route('resources.store'), {
                        onSuccess: (response) => {
                            this.closeModal();
                        }
                    });
                }
            },
        }
    }
</script>




fruit = 'apple';

fruits = ['apple', 'orange', 'cherry', .......]
