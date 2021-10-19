<template>
    <div class="px-5 py-2">
        <div class="grid sm:grid-cols-2 md:grid-cols-4">
            <div class="col-span-1">
                <div class="hover-trigger flex items-center">
                    <h2 class="text-4xl heading-color">{{ creature.display_name }}</h2>
                    <jet-dropdown align="left" width="48" class="hover-target ml-1">
                        <template #trigger>
                            <button class="flex link link-color">
                                <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <div>
                                <jet-dropdown-link @click.native="toggleModifiers" v-if="ownerOrAdmin">
                                    {{ creature.show_modifiers ? 'Hide' : 'Show' }} Modifiers
                                </jet-dropdown-link>
                                <jet-dropdown-link @click.native="toggleResources" v-if="ownerOrAdmin">
                                    {{ creature.show_resources ? 'Hide' : 'Show' }} Resources
                                </jet-dropdown-link>
                                <jet-dropdown-link @click.native="toggleNotes" v-if="ownerOrAdmin">
                                    {{ creature.show_notes ? 'Hide' : 'Show' }} Notes
                                </jet-dropdown-link>
                                <jet-dropdown-link @click.native="toggleDice" v-if="ownerOrAdmin">
                                    {{ creature.show_dice ? 'Hide' : 'Show' }} Dice
                                </jet-dropdown-link>
                                <jet-dropdown-link @click.native="toggleAdditionalStats" v-if="ownerOrAdmin">
                                    {{ creature.show_additional_stats ? 'Hide' : 'Show' }} Additional Stats
                                </jet-dropdown-link>
                                <jet-dropdown-link @click.native="clone_creature = true" as="button" v-if="type == 'Monster'">
                                    Clone {{ creature.display_name }}
                                </jet-dropdown-link>
                                <jet-dropdown-link :href="getRoute('edit')" v-if="ownerOrAdmin">
                                    Edit {{ creature.display_name }}
                                </jet-dropdown-link>
                                <jet-dropdown-link @click.native="delete_creature = true" as="button" v-if="ownerOrAdmin">
                                    Delete {{ creature.display_name }}
                                </jet-dropdown-link>
                            </div>
                        </template>
                    </jet-dropdown>
                </div>
                <span class="ml-1 text-xs text-secondary-color" v-if="type == 'Character'">
                    Level {{ creature.level }} {{ creature.race }} {{ creature.class }}
                </span>
                <span class="ml-1 text-xs text-secondary-color" v-if="type == 'Monster' || type == 'Encounter Monster'">
                    {{ creature.size }} {{ creature.type }}, {{ creature.alignment }} (CR {{ creature.challenge_rating }})
                </span>
            </div>

            <div class="col-span-3 flex justify-between flex-wrap">
                <div class="flex flex-col justify-between my-1 md:my-0">
                    <p>AC: {{ creature.ac }} <span class="text-xs text-secondary-color">({{ creature.ac_source }})</span></p>
                    <p>Speed: {{ creature.speed }}</p>
                    <div>
                        <button class="btn-text" @click="roll('Initiative', creature.initiative)" :disabled="disabled">
                            Initiative: {{ creature.initiative }}
                        </button>
                    </div>
                </div>
                <div class=" my-1 md:my-0">
                    Hit Dice:
                    <button class="block btn-text" v-for="(hit_dice, index) in creature.hit_dice" @click="rollHitDice(index)" :disabled="disabled">
                        {{ hit_dice.current }}/{{ hit_dice.count }}d{{ hit_dice.size }}
                    </button>
                </div>
                <div class="text-right my-1 md:my-0">
                    HP: <jet-input type="number" class="w-16 p-1" v-model.number="creature.hp_current" @blur="updateCreature" v-if="!disabled"/> <span v-if="!disabled">/</span> {{creature.hp_max}}
                    <div v-if="!disabled">
                        <span class="text-xs">Calc:</span> <jet-input type="number" class="w-16 p-1 mt-1" @keyup.enter="adjustCurrentHp()" v-model.number="hp_calculator"/> <span class="invisible">/ {{creature.hp_max}}</span>
                    </div>
                </div>
                <div class="text-right my-1 md:my-0" v-if="!disabled">
                    Temp HP: <jet-input type="number" class="w-16 p-1" v-model.number="creature.hp_temp" @blur="updateCreature"/><br>
                    <span class="text-xs">Calc:</span> <jet-input type="number" class="w-16 p-1 mt-1" @keyup.enter="adjustTempHp()" v-model.number="hp_temp_calculator"/>
                </div>
            </div>
        </div>

        <!-- delete confirmation -->
        <jet-confirmation-modal :show="delete_creature" @close="delete_creature = false">
            <template #title>
                Delete {{ creature.display_name }}
            </template>

            <template #content>
                Are you sure you want to delete {{ creature.display_name }}?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="delete_creature = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteCreature" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete {{ creature.display_name }}
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

        <!-- clone -->
        <jet-dialog-modal type="form" :show="clone_creature" @close="closeClone" @submitted="cloneCreature">
            <template #header>
                Clone {{ creature.display_name }}
            </template>

            <template #content>
                <!-- name -->
                <jet-label for="name" value="Name for Clone"/>
                <jet-input type="text" id="name" class="mt-1 w-full" v-model="form.name" required/>
                <jet-input-error :message="form.errors.name" class="mt-2"/>
            </template>

            <template #footerend>
                <jet-secondary-button @click.native="closeClone">
                    Cancel
                </jet-secondary-button>
                <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Clone {{ creature.display_name }}
                </jet-button>
            </template>
        </jet-dialog-modal>
    </div>
</template>

<script>
    import JetInput from '@/Jetstream/Input'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetLabel from '@/Jetstream/Label'
    import JetInputError from '@/Jetstream/InputError'

    import { Flash } from '@/Mixins/Flash';
    import { CreatureBase } from '@/Mixins/Creature/Base';

    export default {
        components: {
            JetInput,
            JetDropdown,
            JetDropdownLink,
            JetButton,
            JetSecondaryButton,
            JetDangerButton,
            JetDialogModal,
            JetConfirmationModal,
            JetLabel,
            JetInputError,
        },
        data() {
            return {
                delete_creature: false,
                clone_creature: false,
                hp_calculator: null,
                hp_temp_calculator: null,
                form: this.$inertia.form({
                    id: this.creature.id,
                    name: null,
                }),
            }
        },
        mixins: [Flash, CreatureBase],
        methods: {
            roll(item, modifier) {
                let result =  dice.roll();
                let message = this.creature.display_name + ':<br>' +
                    item + ': [' + result + ']' + (modifier ? ' + ' + modifier : '') + ' = ' + (result + modifier);
                this.flash(message, 'primary');
            },
            adjustCurrentHp() {
                if (Number.isInteger(this.creature.hp_current) && Number.isInteger(this.hp_calculator)) {
                    this.creature.hp_current += this.hp_calculator;
                    this.updateCreature(true);
                }
                this.hp_calculator = null;
            },
            adjustTempHp() {
                if (Number.isInteger(this.creature.hp_temp) && Number.isInteger(this.hp_temp_calculator)) {
                    this.creature.hp_temp += this.hp_temp_calculator;
                    this.updateCreature(true);
                }
                this.hp_temp_calculator = null;
            },
            rollHitDice(dice_index) {
                if (this.creature.hp_current >= this.creature.hp_max) {
                    this.flash('Already at full HP', 'danger');
                } else if (this.creature.hit_dice[dice_index].current == 0) {
                    this.flash('Out of Hit Dice', 'danger');
                } else {
                    this.creature.hit_dice[dice_index].current--;
                    let output = [];
                    let result = dice.roll(this.creature.hit_dice[dice_index].size);
                    let total = result + this.creature.constitution_mod;
                    output.push(this.creature.display_name + ' rolled a hit dice:');
                    if(this.creature.hp_current < 0) {
                        output.push('HP is less than 0; setting HP to 0.');
                        this.creature.hp_current = 0;
                    }
                    output.push('Previous: ' + this.creature.hp_current + ' HP');
                    output.push('Recovered: [' + result + '] + ' + this.creature.constitution_mod + ' = ' + total + ' HP');
                    this.creature.hp_current = this.creature.hp_current + total;
                    if (this.creature.hp_current > this.creature.hp_max) {
                        this.creature.hp_current = this.creature.hp_max;
                    }
                    output.push('New Total: ' + this.creature.hp_current + ' HP');
                    this.flash(output.join('<br>'), 'primary');
                    this.updateCreature(true);
                }
            },
            toggleModifiers() {
                this.creature.show_modifiers = !this.creature.show_modifiers;
                this.updateCreature();
            },
            toggleResources() {
                this.creature.show_resources = !this.creature.show_resources;
                this.updateCreature();
            },
            toggleNotes() {
                this.creature.show_notes = !this.creature.show_notes;
                this.updateCreature();
            },
            toggleDice() {
                this.creature.show_dice = !this.creature.show_dice;
                this.updateCreature();
            },
            toggleAdditionalStats() {
                this.creature.show_additional_stats = !this.creature.show_additional_stats;
                this.updateCreature();
            },
            deleteCreature() {
                this.form.delete(this.getRoute('destroy'));
            },
            cloneCreature() {
                this.form.post(this.getRoute('clone'));
                this.closeClone();
            },
            closeClone() {
                this.form.name = null;
                this.clone_creature = false;
            }
        }
    }
</script>
