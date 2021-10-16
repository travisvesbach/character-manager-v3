<template>
    <grid-section title="Actions">
        <template #button>
            <jet-secondary-button size="sm" @click="openModal()" v-if="ownerOrAdmin">
                Add
            </jet-secondary-button>
        </template>

        <div class="" :class="index != 0 ? 'my-2 border-t dark:border-gray-600 pt-2' : 'mb-2'" v-for="(action, index) in creature.actions">
            <div class="flex">
                <div class="whitespace-nowrap">
                    <button class="btn-text pr-1" @click="openModal(action)" :title="disabled ? '' : 'Edit action'" :disabled="!ownerOrAdmin">
                        {{ action.name }}
                    </button>
                    <span class="border-l-2 dark:border-gray-600 px-1" title="Action type">
                        {{ action.type }}
                    </span>
                    <span class="border-l-2 dark:border-gray-600 px-1" title="Range">
                        {{ action.range }}
                    </span>
                </div>
                <div>
                    <div v-if="action.attack">
                        <span class="border-l-2 dark:border-gray-600 px-1" title="Attack modifier">
                            {{ action.attack_modifier > 0 ? '+' : '' }}{{ action.attack_modifier }}
                        </span>
                        <span class="border-l-2 dark:border-gray-600 px-1" title="Attack damage" v-if="action.attack_does_damage">
                            <span v-for="(dice, index) in action.attack_dice">
                                {{ index > 0 ? ' &' : '' }} {{ dice.count }}d{{ dice.size }}{{ dice.modifier ? '+' + dice.modifier : '' }} {{ dice.type }}
                            </span>
                        </span>
                    </div>
                    <div v-if="action.save">
                        <span class="border-l-2 dark:border-gray-600 px-1" title="Save DC and saving throw type">
                            {{ action.save_dc ? 'DC ' + action.save_dc : '' }} {{ action.save_type }} save
                        </span>
                        <span class="border-l-2 dark:border-gray-600 px-1" title="Save damage" v-if="action.save_does_damage">
                            <span v-for="(dice, index) in action.save_dice">
                                {{ index > 0 ? ' &' : '' }} {{ dice.count }}d{{ dice.size }}{{ dice.modifier ? '+' + dice.modifier : '' }} {{ dice.type }}
                            </span>
                        </span>
                    </div>
                </div>
                <div class="ml-auto mt-0.5 flex items-start" :class="disabled ? 'hidden' : ''">
                    <jet-secondary-button class="mr-1" size="xs" @click="roll(action, 'disadvantage')" v-if="action.attack">
                        -
                    </jet-secondary-button>
                    <jet-secondary-button size="xs" @click="roll(action)">
                        Roll
                    </jet-secondary-button>
                    <jet-secondary-button class="ml-1" size="xs" @click="roll(action, 'advantage')" v-if="action.attack">
                        +
                    </jet-secondary-button>
                </div>
            </div>
            <accordion class="pl-4" :class="action.save && (action.attack || action.auto) ? '-mt-6' : ''" v-if="action.notes">
                <accordion-item justify="start" icon_size="sm" button_width="w-auto">
                    <template v-slot:title>
                        <span class="text-sm font-medium mr-2">Notes</span>
                    </template>
                    <template v-slot:content>
                        {{ action.notes }}
                    </template>
                </accordion-item>
            </accordion>
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

                    <div class="col-span-1 sm:col-span-2 mt-4 pt-2 border-t dark:border-gray-600" v-if="form.attack">
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

                    <div class="col-span-1 sm:col-span-2 mt-4 pt-2 border-t dark:border-gray-600" v-if="form.save">
                        <div class="grid grid-cols-1 sm:grid-cols-3">
                            <div class="col-span-1 px-1">
                                <!-- save_type -->
                                <jet-label for="save_type" value="Save Type"/>
                                <select-input id="save_type" class="mt-1 w-full" v-model="form.save_type" :options="['STR', 'DEX', 'CON', 'INT', 'WIS', 'CHA']"/>
                                <jet-input-error :message="form.errors.save_type" class="mt-2"/>
                            </div>
                            <div class="col-span-1 px-1 mt-4 sm:mt-0">
                                <!-- save_dc -->
                                <jet-label for="save_dc" value="Save DC"/>
                                <jet-input type="number" id="save_dc" class="mt-1 w-full" v-model.number="form.save_dc"/>
                                <jet-input-error :message="form.errors.attack_modifier" class="mt-2"/>
                            </div>
                            <div class="col-span-1 px-1 mt-4 sm:mt-0">
                                <!-- save_does_damage -->
                                <jet-label for="save_does_damage" value="Does Damage"/>
                                <jet-checkbox id="save_does_damage" v-model:checked="form.save_does_damage"/>
                                <jet-input-error :message="form.errors.save_does_damage" class="mt-2"/>
                            </div>
                        </div>
                        <div v-if="form.save_does_damage">
                            <!-- save_dice -->
                            <jet-label for="save_dice" value="Damage" class="mt-4"/>
                            <dice-array-input v-model="form.save_dice" :multiple="true"/>
                            <jet-input-error :message="form.errors.save_dice" class="mt-2"/>
                        </div>

                    </div>

                    <div class="col-span-1 sm:col-span-2 mt-4 pt-2 border-t dark:border-gray-600" v-if="form.auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2">
                            <div class="col-span-1 px-1">
                                <!-- auto_does_damage -->
                                <jet-label for="auto_does_damage" value="Does Damage"/>
                                <jet-checkbox id="auto_does_damage" v-model:checked="form.auto_does_damage"/>
                                <jet-input-error :message="form.errors.auto_does_damage" class="mt-2"/>
                            </div>
                        </div>
                        <div v-if="form.auto_does_damage">
                            <!-- auto_dice -->
                            <jet-label for="auto_dice" value="Damage" class="mt-4"/>
                            <dice-array-input v-model="form.auto_dice" :multiple="true"/>
                            <jet-input-error :message="form.errors.auto_dice" class="mt-2"/>
                        </div>
                    </div>

                    <div class="col-span-1 sm:col-span-2 mt-4 pt-2 border-t dark:border-gray-600">
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
    import Accordion from '@/Components/Accordion'
    import AccordionItem from '@/Components/AccordionItem'

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
            JetCheckbox,
            Accordion,
            AccordionItem,
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
                        attack_dice: action.attack_dice ? JSON.parse(JSON.stringify(action.attack_dice)) : [{
                                count: 0,
                                size: 0,
                                modifier: 0,
                                type: null,
                            }],
                        save: action.save,
                        save_type: action.save_type,
                        save_dc: action.save_dc,
                        save_does_damage: action.save_does_damage,
                        save_dice: action.save_dice ? JSON.parse(JSON.stringify(action.save_dice)) : [{
                                count: 0,
                                size: 0,
                                modifier: 0,
                                type: null,
                            }],
                        auto: action.auto,
                        auto_does_damage: action.auto_does_damage,
                        auto_dice: action.auto_dice ? JSON.parse(JSON.stringify(action.auto_dice)) : [{
                                count: 0,
                                size: 0,
                                modifier: 0,
                                type: null,
                            }],
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
            roll(action, advantage = null) {
                let critical = null;
                let output_array = [];
                output_array.push(this.creature.name + ':<br>' + action.name + (advantage ? ' with ' + advantage : '') + ':');

                // get attack roll(s)
                if(action.attack) {
                    let attack_rolls = [];
                    attack_rolls.push(dice.roll());
                    if(advantage) {
                        attack_rolls.push(dice.roll());
                    }
                    let attack_total = attack_rolls[0];
                    if(advantage == 'advantage') {
                        attack_total = Math.max(...attack_rolls);
                    } else if(advantage == 'disadvantage') {
                        attack_total = Math.min(...attack_rolls);
                    }

                    // check if critical hit
                    let crit_min = this.creature.modifiers.reduce((min, modifier) => modifier.enabled && modifier.critical_range ? modifier.critical_range_start < min ? modifier.critical_range_start : min : min, 20);
                    critical = attack_total >= crit_min ? 'success' : attack_total == 1 ? 'fail' : false;

                    if(action.attack_modifier) {
                        attack_total += action.attack_modifier;
                    }
                    let message = 'Attack roll: [' + attack_rolls.join(',') + ']' + (action.attack_modifier ? ' + ' + action.attack_modifier : '');

                    // get attack modifiers
                    let attack_modifiers = this.creature.modifiers.filter(value => value.enabled && value['attack']);

                    for(const mod of attack_modifiers) {
                        for(const mod_dice of mod['attack_dice']) {
                            message += (mod_dice.count > 0 ? ' + [' : '');
                            for(let x=0;x<mod_dice.count;x++) {
                                let result = dice.roll(mod_dice.size);
                                message += (x > 0 ? ', ' : '') + result;
                                attack_total += result
                            }
                            message += mod_dice.count > 0 ? ']' : '';
                            if(mod_dice.modifier) {
                                message += (mod_dice.modifier ? ' + ' + mod_dice.modifier : '');
                                attack_total += mod_dice.modifier;
                            }
                            message += ' [' + mod.name + ']';
                        }
                    }

                    message += ' = ' + (attack_total);

                    output_array.push(message);

                    if(critical == 'success') {
                        output_array.push('Critical Hit!');
                    }
                    if(critical == 'fail') {
                        output_array.push('Critical Fail...');
                        this.flash(output_array.join('<br>'), 'danger');
                        return;
                    }
                }

                let damage = {
                    types: [],
                    total: 0,
                    saves: [],
                    output_array: [],
                }

                // roll damage/save
                if(action.attack && action.attack_does_damage) {
                    damage = this.rollDamage(damage, action.attack_dice, critical);
                }
                if(action.auto && action.auto_does_damage) {
                    damage = this.rollDamage(damage, action.auto_dice);
                }
                if(action.save) {
                    damage = this.rollSave(damage, action);
                }

                // roll active damage modifiers
                this.creature.modifiers.filter(value => value.enabled && value['damage']).forEach(function(modifier) {
                    if(modifier.damage_as == 'attack') {
                        damage = this.rollDamage(damage, modifier.damage_dice, critical, modifier.name);
                    }
                    if (modifier.damage_as == 'save') {
                        damage = this.rollSave(damage, {
                            name: modifier.name,
                            save_dc: modifier.damage_dc,
                            save_type: modifier.damage_save,
                            save_dice: modifier.damage_dice,
                            save_does_damage: true,
                        });
                    }
                }, this);

                // add damage.types to ouput_array
                if(damage.types && damage.types.length > 0) {
                    damage.types.forEach(function(type) {
                        output_array.push(type.output + ' = ' + type.total);
                    });
                    if(damage.types.length > 1) {
                        output_array.push('Total Attack Damage: ' + damage.total);
                    }
                }
                // add damage.saves to ouput_array
                if(damage.saves && damage.saves.length > 0) {
                    damage.saves.forEach(function(damage_save) {
                        output_array = output_array.concat(damage_save.output_array);
                    });
                }

                // add notes to output
                let notes = [];
                if(action.notes && action.notes.length > 0) {
                    notes.push(action.notes);
                }
                this.creature.modifiers.filter(value => value.enabled && value['attack']).forEach(function(modifier) {
                    if(modifier.notes && modifier.notes.length > 0) {
                        notes.push(modifier.name + ': ' + modifier.notes);
                    }
                });
                this.creature.modifiers.filter(value => value.enabled && value['damage']).forEach(function(modifier) {
                    if(modifier.notes && modifier.notes.length > 0) {
                        notes.push(modifier.name + ': ' + modifier.notes);
                    }
                });
                if(notes.length > 0) {
                    output_array.push('-------------------------');
                    output_array = output_array.concat(notes);
                }

                this.flash(output_array.join('<br>'), critical == 'success' ? 'success' : 'primary');
            },
            rollDamage(damage, dice_array, critical = null, name = null) {
                dice_array.forEach(function(dice_obj) {
                    let damage_roll = null
                    let total = dice_obj.modifier;
                    let damage_rolls_array = [];
                    if(dice_obj.count > 0) {
                        for(let i=0;i<(critical == 'success' ? 2 : 1);i++) {
                            for(let x=0;x<dice_obj.count;x++) {
                                damage_roll = dice.roll(dice_obj.size);
                                total = total + damage_roll;
                                damage_rolls_array.push(damage_roll);
                            }
                        }
                    }
                    let type_index = dice_obj.type == 'Same as attack' ? 0 : damage.types.findIndex(x => x.type == dice_obj.type);
                    let new_index = false;
                    if(type_index < 0) {
                        damage.types.push({
                            type: dice_obj.type,
                            total: 0,
                            output: dice_obj.type + ' Damage: ',
                        });
                        type_index = damage.types.findIndex(x => x.type == dice_obj.type);
                        new_index = true;
                    }
                    damage.types[type_index].total += total;
                    damage.types[type_index].output += (!new_index ? ' + ' : '')
                        + (damage_rolls_array.length > 0 ? '[' + damage_rolls_array.join(', ') + ']' : '')
                        + (damage_rolls_array.length > 0 && dice_obj.modifier && dice_obj.modifier != 0 ? ' + ' : '')
                        + (dice_obj.modifier && dice_obj.modifier != 0 ? dice_obj.modifier : '')
                        + (name ? ' [' + name + ']' : '');
                    damage.total += total;
                });
                return damage;
            },
            rollSave(damage, action) {
                let output_array = [];
                let total = 0;
                if(!damage.saves) {
                    damage.saves = [];
                }
                output_array.push('Target(s) make a DC ' + action.save_dc + ' ' + action.save_type + ' saving throw.');
                if(action.save_does_damage) {
                    action.save_dice.forEach(function(dice_obj) {
                        let damage_roll = null
                        let damage_rolls_array = [];
                        let damage_total = dice_obj.modifier;
                        for(let i=0;i<dice_obj.count;i++) {
                            damage_roll = dice.roll(dice_obj.size);
                            damage_total += damage_roll;
                            damage_rolls_array.push(damage_roll);
                        }
                        output_array.push(dice_obj.type + ' Damage: [' + damage_rolls_array + '] ' + (dice_obj.modifier ? '+ ' + dice_obj.modifier : '') + ' = ' + damage_total);
                        total += damage_total;
                    }, action);
                    if(action.save_dice.length > 1) {
                        output_array.push('Total Save Damage: ' + total);
                    }
                }
                damage.saves.push({
                    name: action.name,
                    output_array: output_array,
                });
                return damage;
            },

        },
    }
</script>
