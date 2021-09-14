<template>
    <div class="bg-gray-800 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
        <div class="px-2 p-1 col-span-1 border dark:border-gray-700">
            <p>
                <strong>Strength: {{ creature.strength }} ({{ displayStat(creature.strength_mod) }})</strong>
            </p>
            <p>
                Save: {{ displayStat(creature.strength_save) }}
            </p>
            <p>
                Athletics: {{ displayStat(creature.athletics) }}
            </p>
        </div>
        <div class="px-2 p-1 col-span-1 border dark:border-gray-700">
            <p>
                <strong>Dexterity: {{ creature.dexterity }} ({{ displayStat(creature.dexterity_mod) }})</strong>
            </p>
            <p>
                Save: {{ displayStat(creature.dexterity_save) }}
            </p>
            <p>
                Acrobatics: {{ displayStat(creature.acrobatics) }}
            </p>
            <p>
                Slight of Hand: {{ displayStat(creature.sleight_of_hand) }}
            </p>
            <p>
                Stealth: {{ displayStat(creature.stealth) }}
            </p>
        </div>
        <div class="px-2 p-1 col-span-1 border dark:border-gray-700">
            <p>
                <strong>Constitution: {{ creature.constitution }} ({{ displayStat(creature.constitution_mod) }})</strong>
            </p>
            <p>
                Save: {{ displayStat(creature.constitution_save) }}
            </p>
        </div>
        <div class="px-2 p-1 col-span-1 border dark:border-gray-700">
            <p>
                <strong>Intelligence: {{ creature.intelligence }} ({{ displayStat(creature.intelligence_mod) }})</strong>
            </p>
            <p>
                Save: {{ displayStat(creature.intelligence_save) }}
            </p>
            <p>
                Arcana: {{ displayStat(creature.arcana) }}
            </p>
            <p>
                History: {{ displayStat(creature.history) }}
            </p>
            <p>
                Investigation: {{ displayStat(creature.investigation) }}
            </p>
            <p>
                Nature: {{ displayStat(creature.nature) }}
            </p>
            <p>
                Religion: {{ displayStat(creature.religion) }}
            </p>
        </div>
        <div class="px-2 p-1 col-span-1 border dark:border-gray-700">
            <p>
                <strong>Wisdom: {{ creature.wisdom }} ({{ displayStat(creature.wisdom_mod) }})</strong>
            </p>
            <p>
                Save: {{ displayStat(creature.wisdom_save) }}
            </p>
            <p>
                Animal Handling: {{ displayStat(creature.animal_handling) }}
            </p>
            <p>
                Insight: {{ displayStat(creature.insight) }}
            </p>
            <p>
                Medicine: {{ displayStat(creature.medicine) }}
            </p>
            <p>
                Perception: {{ displayStat(creature.perception) }}
            </p>
            <p>
                Survival: {{ displayStat(creature.survival) }}
            </p>
        </div>
        <div class="px-2 p-1 col-span-1 border dark:border-gray-700">
            <p>
                <strong>Charisma: {{ creature.charisma }} ({{ displayStat(creature.charisma_mod) }})</strong>
            </p>
            <p>
                Save: {{ displayStat(creature.charisma_save) }}
            </p>
            <p>
                Deception: {{ displayStat(creature.deception) }}
            </p>
            <p>
                Intimidation: {{ displayStat(creature.intimidation) }}
            </p>
            <p>
                Performance: {{ displayStat(creature.performance) }}
            </p>
            <p>
                Persuasion: {{ displayStat(creature.persuasion) }}
            </p>
        </div>
    </div>
</template>

<script>
    import { flash } from '@/Mixins/Flash';

    export default {
        props: ['creature'],
        components: {
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
        }
    }
</script>
