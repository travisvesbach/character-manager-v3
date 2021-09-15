<template>
    <div class="px-5 py-2">
        <div class="grid grid-cols-4">
            <div class="col-span-1">
                <div class="hover-trigger flex items-center">
                    <h2 class="text-4xl">{{ creature.name }}</h2>
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
                                <jet-dropdown-link @click.native="confirmingDeleteCharacter = creature" as="button">
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

            <div class="col-span-3 flex justify-between">
                <div class="flex flex-col justify-between">
                    <p>AC: {{ creature.ac }} <span class="text-xs text-secondary-color">({{ creature.ac_source }})</span></p>
                    <p>Speed: {{ creature.speed }}</p>
                    <div class="inline-block cursor-pointer" @click="roll('Initiative', creature.initiative)">
                        Initiative: {{ creature.initiative }}
                    </div>
                </div>
                <div class="">
                    Hit Dice:
                    <div v-for="hit_dice in creature.hit_dice">
                        {{ hit_dice.current }}/{{ hit_dice.total }}d{{ hit_dice.size }}
                    </div>
                </div>
                <div class="text-right">
                    HP: <jet-input type="number" class="w-16 p-1" v-model.number="creature.current_hp"/> / {{creature.max_hp}}<br>
                    <span class="text-xs">Calc:</span> <jet-input type="number" class="w-16 p-1 mt-1" @keyup.enter="adjustCurrentHp()" v-model.number="hp_calculator"/> <span class="invisible">/ {{creature.max_hp}}</span>
                </div>
                <div class="text-right">
                    Temp HP: <jet-input type="number" class="w-16 p-1" v-model.number="creature.current_hp"/><br>
                    <span class="text-xs">Calc:</span> <jet-input type="number" class="w-16 p-1 mt-1" @keyup.enter="adjustCurrentHp()" v-model.number="hp_calculator"/>
                </div>
            </div>
        </div>
        <div>
        </div>
    </div>
</template>

<script>
    import JetInput from '@/Jetstream/Input'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'

    import { flash } from '@/Mixins/Flash';

    export default {
        props: ['creature'],
        components: {
            JetInput,
            JetDropdown,
            JetDropdownLink,
        },
        data() {
            return {
                hp_calculator: null,
            }
        },
        mixins: [flash],
        emits: ['updated'],
        watch: {
            creature: {
                handler() {
                    console.log('heading: ' + this.creature.current_hp);
                },
                deep: true,
            }
        },
        methods: {
            roll(item, modifier) {
                let result =  dice.roll();
                let message = this.creature.name + ':<br>' +
                    item + ': [' + result + ']' + (modifier ? ' + ' + modifier : '') + ' = ' + (result + modifier);
                this.flash(message, 'primary');
            },
            adjustCurrentHp() {
                if (Number.isInteger(this.creature.current_hp) && Number.isInteger(this.hp_calculator)) {
                    this.creature.current_hp += this.hp_calculator;
                    this.emitUpdate();
                }
                this.hp_calculator = null;
            },
            emitUpdate() {
                this.$emit('updated', this.creature);
            }
        }
    }
</script>
