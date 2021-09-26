<template>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
        <grid-section>
            <button class="block" @click="roll('Strength', creature.strength_mod)">
                <strong>Strength: {{ creature.strength }} ({{ displayStat(creature.strength_mod) }})</strong>
            </button>
            <button class="block" :class="proficiencyClass(creature.strength_save_proficiency)" @click="roll('Strength Save', creature.strength_save)">
                Save: {{ displayStat(creature.strength_save) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.athletics_proficiency)" @click="roll('Athletics', creature.athletics)">
                Athletics: {{ displayStat(creature.athletics) }}
            </button>
        </grid-section>
        <grid-section>
            <button class="block" @click="roll('Dexterity', creature.dexterity_mod)">
                <strong>Dexterity: {{ creature.dexterity }} ({{ displayStat(creature.dexterity_mod) }})</strong>
            </button>
            <button class="block" :class="proficiencyClass(creature.dexterity_save_proficiency)" @click="roll('Dexterity Save', creature.dexterity_save)">
                Save: {{ displayStat(creature.dexterity_save) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.acrobatics_proficiency)" @click="roll('Acrobatics', creature.acrobatics)">
                Acrobatics: {{ displayStat(creature.acrobatics) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.sleight_of_hand_proficiency)" @click="roll('Slight of Hand', creature.sleight_of_hand)">
                Slight of Hand: {{ displayStat(creature.sleight_of_hand) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.stealth_proficiency)" @click="roll('Stealth', creature.stealth)">
                Stealth: {{ displayStat(creature.stealth) }}
            </button>
        </grid-section>
        <grid-section>
            <button class="block" @click="roll('Constitution', creature.constitution_mod)">
                <strong>Constitution: {{ creature.constitution }} ({{ displayStat(creature.constitution_mod) }})</strong>
            </button>
            <button class="block" :class="proficiencyClass(creature.constitution_save_proficiency)" @click="roll('Constitution Save', creature.constitution_save)">
                Save: {{ displayStat(creature.constitution_save) }}
            </button>
        </grid-section>
        <grid-section>
            <button class="block" @click="roll('Intelligence', creature.intelligence_mod)">
                <strong>Intelligence: {{ creature.intelligence }} ({{ displayStat(creature.intelligence_mod) }})</strong>
            </button>
            <button class="block" :class="proficiencyClass(creature.intelligence_save_proficiency)" @click="roll('Intelligence Save', creature.intelligence_save)">
                Save: {{ displayStat(creature.intelligence_save) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.arcana_proficiency)" @click="roll('Arcana', creature.arcana)">
                Arcana: {{ displayStat(creature.arcana) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.history_proficiency)" @click="roll('History', creature.history)">
                History: {{ displayStat(creature.history) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.investigation_proficiency)" @click="roll('Investigation', creature.investigation)">
                Investigation: {{ displayStat(creature.investigation) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.nature_proficiency)" @click="roll('Nature', creature.nature)">
                Nature: {{ displayStat(creature.nature) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.religion_proficiency)" @click="roll('Religion', creature.religion)">
                Religion: {{ displayStat(creature.religion) }}
            </button>
        </grid-section>
        <grid-section>
            <button class="block" @click="roll('Wisdom', creature.wisdom_mod)">
                <strong>Wisdom: {{ creature.wisdom }} ({{ displayStat(creature.wisdom_mod) }})</strong>
            </button>
            <button class="block" :class="proficiencyClass(creature.wisdom_save_proficiency)" @click="roll('Wisdom Save', creature.wisdom_save)">
                Save: {{ displayStat(creature.wisdom_save) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.animal_handling_proficiency)" @click="roll('Animal Handling', creature.animal_handling)">
                Animal Handling: {{ displayStat(creature.animal_handling) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.insight_proficiency)" @click="roll('Insight', creature.insight)">
                Insight: {{ displayStat(creature.insight) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.medicine_proficiency)" @click="roll('Medicine', creature.medicine)">
                Medicine: {{ displayStat(creature.medicine) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.perception_proficiency)" @click="roll('Perception', creature.perception)">
                Perception: {{ displayStat(creature.perception) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.survival_proficiency)" @click="roll('Survival', creature.survival)">
                Survival: {{ displayStat(creature.survival) }}
            </button>
        </grid-section>
        <grid-section>
            <button class="block" @click="roll('Charisma', creature.charisma_mod)">
                <strong>Charisma: {{ creature.charisma }} ({{ displayStat(creature.charisma_mod) }})</strong>
            </button>
            <button class="block" :class="proficiencyClass(creature.charisma_save_proficiency)" @click="roll('Charisma Save', creature.charisma_save)">
                Save: {{ displayStat(creature.charisma_save) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.deception_proficiency)" @click="roll('Deception', creature.deception)">
                Deception: {{ displayStat(creature.deception) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.intimidation_proficiency)" @click="roll('Intimidation', creature.intimidation)">
                Intimidation: {{ displayStat(creature.intimidation) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.performance_proficiency)" @click="roll('Performance', creature.performance)">
                Performance: {{ displayStat(creature.performance) }}
            </button>
            <button class="block" :class="proficiencyClass(creature.persuasion_proficiency)" @click="roll('Persuasion', creature.persuasion)">
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
            roll(item, modifier) {
                let result =  dice.roll();
                let message = this.creature.name + ':<br>' +
                    item + ': [' + result + ']' + (modifier ? ' + ' + modifier : '') + ' = ' + (result + modifier);
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
