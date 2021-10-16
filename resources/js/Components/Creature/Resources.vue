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
                    <div v-for="dice in resource.dice">
                        {{ dice.count }}d{{ dice.size }}{{ dice.modifier ? '+' + dice.modifier : '' }}
                    </div>
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
                    <dice-array-input v-model="form.dice" :current="true" :multiple="true"/>
                    <jet-input-error :message="form.errors.dice" class="mt-2"/>
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

    import { Flash } from '@/Mixins/Flash';
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
        },
        mixins: [Flash, CreatureComponent],
        data() {
            return {
                show_modal: false,
                show_delete_modal: false,
                form: this.$inertia.form({}),
            };
        },
        methods: {
            setForm(resource = null) {
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
                        dice: JSON.parse(JSON.stringify(resource.dice)),
                        no_alert: false,
                        editing: true,
                    });
                } else {
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
                        no_alert: false,
                    });
                }
            },
            openModal(resource = null) {
                this.setForm(resource);
                this.show_modal = true;
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
            saveResource() {
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
            updateSlot(resource, index) {
                resource.slots[index] = !resource.slots[index];
                this.setForm(resource);
                this.form.no_alert = true;
                this.saveResource();
            },
            rollDice(resource) {
                let total = 0;
                let message = this.creature.name + ':<br>';
                message += resource.name + ':<br>';
                let loop_total = 0;
                for(let i=0;i<resource.dice.length;i++) {
                    loop_total = 0;
                    if(resource.dice[i].size > 0) {
                        message += '[';
                        for(let j=0;j<resource.dice[i].count;j++) {
                            let result = dice.roll(resource.dice[i].size);
                            loop_total += result;
                            message += result + (j < resource.dice[i].count - 1 ? ', ' : '');
                        }
                        message += '] ';
                    }
                    loop_total += getNumber(resource.dice[i].modifier);
                    message += (resource.dice[i].modifier ? (resource.dice[i].size > 0 ? '+ ' : '') + resource.dice[i].modifier : '') + ' = ' + loop_total;

                    total += loop_total;
                    message += '<br>'
                }
                if(total != loop_total) {
                    message += 'Total: ' + total;
                }
                this.flash(message, 'primary');
            },
            deleteResource() {
                this.form.delete(route('resources.destroy', this.form.id));
                this.closeModal();
                this.show_delete_modal = false;
            },
        }
    }
</script>
