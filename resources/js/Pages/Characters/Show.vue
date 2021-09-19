<template>
    <app-layout :title="character.name">
        <template #header>
            {{ character.name }}
        </template>

        <template #subheader>
            <div class="flex items-center px-10">
                <jet-nav-link :href="creature.path" :active="creature.id == character.id" preserve-state v-for="creature in characters" :title="'Level ' + creature.level + ' ' +  creature.race + ' ' +  creature.class">
                    {{ creature.name }}
                </jet-nav-link>
            </div>
        </template>

        <heading :creature="character" type="character" @updated="updateCharacter"/>

        <stats :creature="character"/>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
            <spells :creature="character" type="character" @updated="updateCharacter" v-if="character.spellcaster"/>
        </div>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import Heading from '@/Components/Creature/Heading'
    import Stats from '@/Components/Creature/Stats'
    import Spells from '@/Components/Creature/Spells'

    export default {
        props: ['character', 'characters'],
        components: {
            AppLayout,
            JetDropdown,
            JetDropdownLink,
            JetButton,
            JetSecondaryButton,
            JetDangerButton,
            JetConfirmationModal,
            JetNavLink,
            Heading,
            Stats,
            Spells,
        },
        methods: {
            updateCharacter() {
                let form = this.$inertia.form({
                    id: this.character.id,
                    name: this.character.name,
                    speed: this.character.speed,
                    hp_max: this.character.hp_max,
                    hp_current: this.character.hp_current,
                    hp_temp: this.character.hp_temp,
                    hit_dice: this.character.hit_dice,
                    ac: this.character.ac,
                    ac_source: this.character.ac_source,
                    initiative: this.character.initiative,
                    strength: this.character.strength,
                    strength_save: this.character.strength_save,
                    strength_mod: this.character.strength_mod,
                    strength_save_proficiency: this.character.strength_save_proficiency,
                    athletics: this.character.athletics,
                    athletics_proficiency: this.character.athletics_proficiency,
                    athletics_expertise: this.character.athletics_expertise,
                    dexterity: this.character.dexterity,
                    dexterity_save: this.character.dexterity_save,
                    dexterity_mod: this.character.dexterity_mod,
                    dexterity_save_proficiency: this.character.dexterity_save_proficiency,
                    acrobatics: this.character.acrobatics,
                    acrobatics_proficiency: this.character.acrobatics_proficiency,
                    acrobatics_expertise: this.character.acrobatics_expertise,
                    sleight_of_hand: this.character.sleight_of_hand,
                    sleight_of_hand_proficiency: this.character.sleight_of_hand_proficiency,
                    sleight_of_hand_expertise: this.character.sleight_of_hand_expertise,
                    stealth: this.character.stealth,
                    stealth_proficiency: this.character.stealth_proficiency,
                    stealth_expertise: this.character.stealth_expertise,
                    constitution: this.character.constitution,
                    constitution_save: this.character.constitution_save,
                    constitution_mod: this.character.constitution_mod,
                    constitution_save_proficiency: this.character.constitution_save_proficiency,
                    intelligence: this.character.intelligence,
                    intelligence_save: this.character.intelligence_save,
                    intelligence_mod: this.character.intelligence_mod,
                    intelligence_save_proficiency: this.character.intelligence_save_proficiency,
                    arcana: this.character.arcana,
                    arcana_proficiency: this.character.arcana_proficiency,
                    arcana_expertise: this.character.arcana_expertise,
                    history: this.character.history,
                    history_proficiency: this.character.history_proficiency,
                    history_expertise: this.character.history_expertise,
                    investigation: this.character.investigation,
                    investigation_proficiency: this.character.investigation_proficiency,
                    investigation_expertise: this.character.investigation_expertise,
                    nature: this.character.nature,
                    nature_proficiency: this.character.nature_proficiency,
                    nature_expertise: this.character.nature_expertise,
                    religion: this.character.religion,
                    religion_proficiency: this.character.religion_proficiency,
                    religion_expertise: this.character.religion_expertise,
                    wisdom: this.character.wisdom,
                    wisdom_save: this.character.wisdom_save,
                    wisdom_mod: this.character.wisdom_mod,
                    wisdom_save_proficiency: this.character.wisdom_save_proficiency,
                    animal_handling: this.character.animal_handling,
                    animal_handling_proficiency: this.character.animal_handling_proficiency,
                    animal_handling_expertise: this.character.animal_handling_expertise,
                    insight: this.character.insight,
                    insight_proficiency: this.character.insight_proficiency,
                    insight_expertise: this.character.insight_expertise,
                    medicine: this.character.medicine,
                    medicine_proficiency: this.character.medicine_proficiency,
                    medicine_expertise: this.character.medicine_expertise,
                    perception: this.character.perception,
                    perception_proficiency: this.character.perception_proficiency,
                    perception_expertise: this.character.perception_expertise,
                    survival: this.character.survival,
                    survival_proficiency: this.character.survival_proficiency,
                    survival_expertise: this.character.survival_expertise,
                    charisma: this.character.charisma,
                    charisma_save: this.character.charisma_save,
                    charisma_mod: this.character.charisma_mod,
                    charisma_save_proficiency: this.character.charisma_save_proficiency,
                    deception: this.character.deception,
                    deception_proficiency: this.character.deception_proficiency,
                    deception_expertise: this.character.deception_expertise,
                    intimidation: this.character.intimidation,
                    intimidation_proficiency: this.character.intimidation_proficiency,
                    intimidation_expertise: this.character.intimidation_expertise,
                    performance: this.character.performance,
                    performance_proficiency: this.character.performance_proficiency,
                    performance_expertise: this.character.performance_expertise,
                    persuasion: this.character.persuasion,
                    persuasion_proficiency: this.character.persuasion_proficiency,
                    persuasion_expertise: this.character.persuasion_expertise,
                    skills_auto_filled: this.character.skills_auto_filled,
                    special_skill_modifiers: this.character.special_skill_modifiers,
                    spellcaster: this.character.spellcaster,
                    spell_type: this.character.spell_type,
                    spell_dc: this.character.spell_dc,
                    spell_level: this.character.spell_level,
                    spell_points_max: this.character.spell_points_max,
                    spell_points_current: this.character.spell_points_current,
                    spell_recover: this.character.spell_recover,
                    spell_list_type: this.character.spell_list_type,
                    spell_prepare_count: this.character.spell_prepare_count,
                    spell_slots_1: this.character.spell_slots_1,
                    spell_slots_2: this.character.spell_slots_2,
                    spell_slots_3: this.character.spell_slots_3,
                    spell_slots_4: this.character.spell_slots_4,
                    spell_slots_5: this.character.spell_slots_5,
                    spell_slots_6: this.character.spell_slots_6,
                    spell_slots_7: this.character.spell_slots_7,
                    spell_slots_8: this.character.spell_slots_8,
                    spell_slots_9: this.character.spell_slots_9,
                    spell_list_0: this.character.spell_list_0,
                    spell_list_1: this.character.spell_list_1,
                    spell_list_2: this.character.spell_list_2,
                    spell_list_3: this.character.spell_list_3,
                    spell_list_4: this.character.spell_list_4,
                    spell_list_5: this.character.spell_list_5,
                    spell_list_6: this.character.spell_list_6,
                    spell_list_7: this.character.spell_list_7,
                    spell_list_8: this.character.spell_list_8,
                    spell_list_9: this.character.spell_list_9,
                    // character fields
                    race: this.character.race,
                    class: this.character.class,
                    level: this.character.level,
                });

                form.patch(route('characters.update', form.id), {
                    // preserveState: true,
                    preserveScroll: true,
                });
            }
        }
    }
</script>
