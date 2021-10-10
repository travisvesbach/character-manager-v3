<template>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
        <grid-section>
            <button class="block btn-text" @click="roll('Strength', creature.strength_mod, 'ability')">
                <strong>Strength: {{ creature.strength }} ({{ displayStat(creature.strength_mod) }})</strong>
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.strength_save_proficiency)" @click="roll('Strength Save', creature.strength_save, 'save')">
                Save: {{ displayStat(creature.strength_save) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.athletics_proficiency)" @click="roll('Athletics', creature.athletics, 'ability')">
                Athletics: {{ displayStat(creature.athletics) }}
            </button>
        </grid-section>
        <grid-section>
            <button class="block btn-text" @click="roll('Dexterity', creature.dexterity_mod, 'ability')">
                <strong>Dexterity: {{ creature.dexterity }} ({{ displayStat(creature.dexterity_mod) }})</strong>
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.dexterity_save_proficiency)" @click="roll('Dexterity Save', creature.dexterity_save, 'save')">
                Save: {{ displayStat(creature.dexterity_save) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.acrobatics_proficiency)" @click="roll('Acrobatics', creature.acrobatics, 'ability')">
                Acrobatics: {{ displayStat(creature.acrobatics) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.sleight_of_hand_proficiency)" @click="roll('Slight of Hand', creature.sleight_of_hand, 'ability')">
                Slight of Hand: {{ displayStat(creature.sleight_of_hand) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.stealth_proficiency)" @click="roll('Stealth', creature.stealth, 'ability')">
                Stealth: {{ displayStat(creature.stealth) }}
            </button>
        </grid-section>
        <grid-section>
            <button class="block btn-text" @click="roll('Constitution', creature.constitution_mod, 'ability')">
                <strong>Constitution: {{ creature.constitution }} ({{ displayStat(creature.constitution_mod) }})</strong>
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.constitution_save_proficiency)" @click="roll('Constitution Save', creature.constitution_save, 'save')">
                Save: {{ displayStat(creature.constitution_save) }}
            </button>
        </grid-section>
        <grid-section>
            <button class="block btn-text" @click="roll('Intelligence', creature.intelligence_mod, 'ability')">
                <strong>Intelligence: {{ creature.intelligence }} ({{ displayStat(creature.intelligence_mod) }})</strong>
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.intelligence_save_proficiency)" @click="roll('Intelligence Save', creature.intelligence_save, 'save')">
                Save: {{ displayStat(creature.intelligence_save) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.arcana_proficiency)" @click="roll('Arcana', creature.arcana, 'ability')">
                Arcana: {{ displayStat(creature.arcana) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.history_proficiency)" @click="roll('History', creature.history, 'ability')">
                History: {{ displayStat(creature.history) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.investigation_proficiency)" @click="roll('Investigation', creature.investigation, 'ability')">
                Investigation: {{ displayStat(creature.investigation) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.nature_proficiency)" @click="roll('Nature', creature.nature, 'ability')">
                Nature: {{ displayStat(creature.nature) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.religion_proficiency)" @click="roll('Religion', creature.religion, 'ability')">
                Religion: {{ displayStat(creature.religion) }}
            </button>
        </grid-section>
        <grid-section>
            <button class="block btn-text" @click="roll('Wisdom', creature.wisdom_mod, 'ability')">
                <strong>Wisdom: {{ creature.wisdom }} ({{ displayStat(creature.wisdom_mod) }})</strong>
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.wisdom_save_proficiency)" @click="roll('Wisdom Save', creature.wisdom_save, 'save')">
                Save: {{ displayStat(creature.wisdom_save) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.animal_handling_proficiency)" @click="roll('Animal Handling', creature.animal_handling, 'ability')">
                Animal Handling: {{ displayStat(creature.animal_handling) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.insight_proficiency)" @click="roll('Insight', creature.insight, 'ability')">
                Insight: {{ displayStat(creature.insight) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.medicine_proficiency)" @click="roll('Medicine', creature.medicine, 'ability')">
                Medicine: {{ displayStat(creature.medicine) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.perception_proficiency)" @click="roll('Perception', creature.perception, 'ability')">
                Perception: {{ displayStat(creature.perception) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.survival_proficiency)" @click="roll('Survival', creature.survival, 'ability')">
                Survival: {{ displayStat(creature.survival) }}
            </button>
        </grid-section>
        <grid-section>
            <button class="block btn-text" @click="roll('Charisma', creature.charisma_mod, 'ability')">
                <strong>Charisma: {{ creature.charisma }} ({{ displayStat(creature.charisma_mod) }})</strong>
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.charisma_save_proficiency)" @click="roll('Charisma Save', creature.charisma_save, 'save')">
                Save: {{ displayStat(creature.charisma_save) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.deception_proficiency)" @click="roll('Deception', creature.deception, 'ability')">
                Deception: {{ displayStat(creature.deception) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.intimidation_proficiency)" @click="roll('Intimidation', creature.intimidation, 'ability')">
                Intimidation: {{ displayStat(creature.intimidation) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.performance_proficiency)" @click="roll('Performance', creature.performance, 'ability')">
                Performance: {{ displayStat(creature.performance) }}
            </button>
            <button class="block btn-text" :class="proficiencyClass(creature.persuasion_proficiency)" @click="roll('Persuasion', creature.persuasion, 'ability')">
                Persuasion: {{ displayStat(creature.persuasion) }}
            </button>
        </grid-section>
    </div>
</template>

<script>
    import GridSection from '@/Components/GridSection';

    import { flash } from '@/Mixins/Flash';

    export default {
        props: ['creature'],
        components: {
            GridSection,
        },
        mixins: [flash],
        methods: {
            roll(item, modifier, type) {
                let modifiers = this.creature.modifiers.filter(value => value.enabled && value[type]);
                let total = dice.roll();
                let message = this.creature.name + ':<br>' + item + ': [' + total + ']' + (modifier ? ' + ' + modifier : '');

                total += modifier;
                for(const mod of modifiers) {
                    for(const mod_dice of mod[type + '_dice']) {
                        message += (mod_dice.count > 0 ? ' + [' : '');
                        for(let x=0;x<mod_dice.count;x++) {
                            let result = dice.roll(mod_dice.size);
                            message += (x > 0 ? ', ' : '') + result;
                            total += result
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
