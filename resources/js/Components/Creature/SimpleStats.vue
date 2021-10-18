<template>
    <div>
        <div class="grid grid-cols-6">
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Strength', creature.strength_mod, 'ability')">
                    STR
                </jet-secondary-button><br>
                <jet-secondary-button size="xs" @click="roll('Strength Save', creature.strength_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Dexterity', creature.dexterity_mod, 'ability')">
                    DEX
                </jet-secondary-button><br>
                <jet-secondary-button size="xs" @click="roll('Dexterity Save', creature.dexterity_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Constitution', creature.constitution_mod, 'ability')">
                    CON
                </jet-secondary-button><br>
                <jet-secondary-button size="xs" @click="roll('Constitution Save', creature.constitution_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Intelligence', creature.intelligence_mod, 'ability')">
                    INT
                </jet-secondary-button><br>
                <jet-secondary-button size="xs" @click="roll('Intelligence Save', creature.intelligence_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Wisdom', creature.wisdom_mod, 'ability')">
                    WIS
                </jet-secondary-button><br>
                <jet-secondary-button size="xs" @click="roll('Wisdom Save', creature.wisdom_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Charisma', creature.charisma_mod, 'ability')">
                    CHA
                </jet-secondary-button><br>
                <jet-secondary-button size="xs" @click="roll('Charisma Save', creature.charisma_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
        </div>
        <div class="flex flex-wrap justify-around">

            <jet-secondary-button class="m-1" size="xs" @click="roll(skill.name, creature[skill.slug], 'ability')" v-for="skill in proficientSkills">
                {{ skill.name }}
            </jet-secondary-button>

<!--             <button class="block btn-text" :class="proficiencyClass(creature.athletics_proficiency)" @click="roll('Athletics', creature.athletics, 'ability')" :disabled="disabled">
                Athletics: {{ displayStat(creature.athletics) }}
            </button> -->
        </div>
    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import GridSection from '@/Components/GridSection';

    import { Flash } from '@/Mixins/Flash';
    import { CreatureComponent } from '@/Mixins/CreatureComponent';
    import { CreatureSkills } from '@/Mixins/CreatureSkills';

    export default {
        components: {
            JetButton,
            JetSecondaryButton,
            JetDialogModal,
            GridSection,
        },
        mixins: [Flash, CreatureComponent, CreatureSkills],
        data() {
            return {
                rest_length: null,
            }
        },
        methods: {
            roll(item, modifier, type) {
                let modifiers = this.creature.modifiers.filter(value => value.enabled && value[type]);
                let total = dice.roll();
                let message = this.creature.display_name + ':<br>' + item + ': [' + total + ']' + (modifier ? ' + ' + modifier : '');

                total += modifier;
                for(const mod of modifiers) {
                    for(const mod_dice of mod[type + '_dice']) {
                        message += (mod_dice.count > 0 ? ' + [' : '');
                        for(let x=0;x<mod_dice.count;x++) {
                            let result = dice.roll(mod_dice.size);
                            message += (x > 0 ? ', ' : '') + result;
                            total += result;
                        }
                        message += mod_dice.count > 0 ? ']' : '';
                        if(mod_dice.modifier) {
                            message += (mod_dice.modifier ? ' + ' + mod_dice.modifier : '');
                            total += mod_dice.modifier;
                        }
                        message += ' [' + mod.name + ']';
                    }
                }
                message += ' = ' + (total);
                this.flash(message, 'primary');
            },
            displayStat(stat) {
                return (stat > 0 ? '+' : '') + stat;
            },
            proficiencyClass(proficient) {
                return proficient ? 'italic' : '';
            }
        }
    }
</script>
