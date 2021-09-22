<template>
    <div class="px-5 py-2">
        <div class="grid sm:grid-cols-2 md:grid-cols-4">
            <div class="col-span-1">
                <div class="hover-trigger flex items-center">
                    <h2 class="text-4xl heading-color">{{ creature.name }}</h2>
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
                                <jet-dropdown-link :href="route('characters.edit', creature.id)">
                                    Edit Character
                                </jet-dropdown-link>
                                <jet-dropdown-link @click.native="confirmingDeleteCreature = creature" as="button">
                                    Delete Character
                                </jet-dropdown-link>
                            </div>
                        </template>
                    </jet-dropdown>
                </div>
                <span class="ml-1 text-xs text-secondary-color">
                    Level {{ creature.level }} {{ creature.race }} {{ creature.class }}
                </span>
            </div>

            <div class="col-span-3 flex justify-between flex-wrap">
                <div class="flex flex-col justify-between my-1 md:my-0">
                    <p>AC: {{ creature.ac }} <span class="text-xs text-secondary-color">({{ creature.ac_source }})</span></p>
                    <p>Speed: {{ creature.speed }}</p>
                    <div>
                        <button @click="roll('Initiative', creature.initiative)">
                            Initiative: {{ creature.initiative }}
                        </button>
                    </div>
                </div>
                <div class=" my-1 md:my-0">
                    Hit Dice:
                    <button class="block" v-for="(hit_dice, index) in creature.hit_dice" @click="rollHitDice(index)">
                        {{ hit_dice.current }}/{{ hit_dice.count }}d{{ hit_dice.size }}
                    </button>
                </div>
                <div class="text-right my-1 md:my-0">
                    HP: <jet-input type="number" class="w-16 p-1" v-model.number="creature.hp_current" @input="updateCreature"/> / {{creature.hp_max}}<br>
                    <span class="text-xs">Calc:</span> <jet-input type="number" class="w-16 p-1 mt-1" @keyup.enter="adjustCurrentHp()" v-model.number="hp_calculator"/> <span class="invisible">/ {{creature.hp_max}}</span>
                </div>
                <div class="text-right my-1 md:my-0">
                    Temp HP: <jet-input type="number" class="w-16 p-1" v-model.number="creature.hp_temp"/><br>
                    <span class="text-xs">Calc:</span> <jet-input type="number" class="w-16 p-1 mt-1" @keyup.enter="adjustTempHp()" v-model.number="hp_temp_calculator"/>
                </div>
            </div>
        </div>

        <!-- delete confirmation -->
        <jet-confirmation-modal :show="confirmingDeleteCreature" @close="confirmingDeleteCreature = false">
            <template #title>
                Delete Character
            </template>

            <template #content>
                Are you sure you want to delete this character?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="confirmingDeleteCreature = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteCreature" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Character
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </div>
</template>

<script>
    import JetInput from '@/Jetstream/Input'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'

    import { flash } from '@/Mixins/Flash';
    import { creatureEmit } from '@/Mixins/Creature/Emit';

    export default {
        props: ['creature', 'type'],
        components: {
            JetInput,
            JetDropdown,
            JetDropdownLink,
            JetSecondaryButton,
            JetDangerButton,
            JetConfirmationModal,
        },
        data() {
            return {
                confirmingDeleteCreature: false,
                hp_calculator: null,
                hp_temp_calculator: null,
                form: this.$inertia.form({
                    id: null,
                }),
            }
        },
        mixins: [flash, creatureEmit],
        methods: {
            roll(item, modifier) {
                let result =  dice.roll();
                let message = this.creature.name + ':<br>' +
                    item + ': [' + result + ']' + (modifier ? ' + ' + modifier : '') + ' = ' + (result + modifier);
                this.flash(message, 'primary');
            },
            adjustCurrentHp() {
                if (Number.isInteger(this.creature.hp_current) && Number.isInteger(this.hp_calculator)) {
                    this.creature.hp_current += this.hp_calculator;
                    this.updateCreature();
                }
                this.hp_calculator = null;
            },
            adjustTempHp() {
                if (Number.isInteger(this.creature.hp_temp) && Number.isInteger(this.hp_temp_calculator)) {
                    this.creature.hp_temp += this.hp_temp_calculator;
                    this.updateCreature();
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
                    output.push(this.creature.name + ' rolled a hit dice:');
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
                    this.updateCreature();
                }
            },
            deleteCreature() {
                this.form.id = this.creature.id;
                this.form.delete(route(this.type + 's.destroy', this.form.id));
            }
        }
    }
</script>
