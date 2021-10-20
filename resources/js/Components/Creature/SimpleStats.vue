<template>
    <div>
        <div class="grid grid-cols-6">
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Strength', creature.strength_mod, 'ability')">
                    STR
                </jet-secondary-button><br>
                <jet-secondary-button class="mt-1" size="xs" @click="roll('Strength Save', creature.strength_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Dexterity', creature.dexterity_mod, 'ability')">
                    DEX
                </jet-secondary-button><br>
                <jet-secondary-button class="mt-1" size="xs" @click="roll('Dexterity Save', creature.dexterity_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Constitution', creature.constitution_mod, 'ability')">
                    CON
                </jet-secondary-button><br>
                <jet-secondary-button class="mt-1" size="xs" @click="roll('Constitution Save', creature.constitution_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Intelligence', creature.intelligence_mod, 'ability')">
                    INT
                </jet-secondary-button><br>
                <jet-secondary-button class="mt-1" size="xs" @click="roll('Intelligence Save', creature.intelligence_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Wisdom', creature.wisdom_mod, 'ability')">
                    WIS
                </jet-secondary-button><br>
                <jet-secondary-button class="mt-1" size="xs" @click="roll('Wisdom Save', creature.wisdom_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
            <div class="col-span-1 text-center">
                <jet-secondary-button size="xs" @click="roll('Charisma', creature.charisma_mod, 'ability')">
                    CHA
                </jet-secondary-button><br>
                <jet-secondary-button class="mt-1" size="xs" @click="roll('Charisma Save', creature.charisma_save, 'save')">
                    Save
                </jet-secondary-button>
            </div>
        </div>
        <div class="flex flex-wrap justify-around">
            <jet-secondary-button class="mt-1 mx-1" size="xs" @click="roll(skill.name, creature[skill.slug], 'ability')" v-for="skill in proficientSkills('ability')">
                {{ skill.name }}
            </jet-secondary-button>
        </div>
    </div>
</template>

<script>
    import { CreatureStats } from '@/Mixins/Creature/Stats';

    export default {
        mixins: [CreatureStats],
    }
</script>
