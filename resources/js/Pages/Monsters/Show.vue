<template>
    <app-layout :title="monster.name">
        <template #header>
            {{ monster.name }}
        </template>

        <heading :creature="monster" type="Monster" @updated="updateMonster"/>

        <stats :creature="monster" @rest="rest"/>

        <div class="grid lg:grid-cols-2">

            <div class="flex flex-col">
                <actions class="flex-grow" :creature="monster" type="Monster"/>

                <dice :creature="monster" v-if="monster.show_dice"/>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-6">
                <modifiers class="lg:col-span-3" :class="getWidth('modifiers')" :creature="monster" type="Monster" v-if="monster.show_modifiers"/>

                <resources class="lg:col-span-3" :class="getWidth('resources')" :creature="monster" type="Monster" v-if="monster.show_resources"/>

                <spells class="lg:col-span-3 lg:col-span-3" :class="getWidth('spellcaster')" :creature="monster" @updated="updateMonster" v-if="monster.spellcaster"/>

                <notepad class="lg:col-span-3" :class="getWidth('notes')" :creature="monster" type="Monster" @updated="updateMonster" v-if="monster.show_notes"/>
            </div>

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
    import Resources from '@/Components/Creature/Resources'
    import Modifiers from '@/Components/Creature/Modifiers'
    import Actions from '@/Components/Creature/Actions'
    import Notepad from '@/Components/Creature/Notepad'
    import Dice from '@/Components/Creature/Dice'

    export default {
        props: ['monster'],
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
            Resources,
            Modifiers,
            Actions,
            Notepad,
            Dice,
        },
        methods: {
            getWidth(item) {
                let sections = {
                    modifiers: this.monster.show_modifiers,
                    resources: this.monster.show_resources,
                    spellcaster: this.monster.spellcaster,
                    notes: this.monster.show_notes,
                };

                let show_count = 0;
                show_count += sections['modifiers'] ? 1 : 0;
                show_count += sections['resources'] ? 1 : 0;
                show_count += sections['spellcaster'] ? 1 : 0;
                show_count += sections['notes'] ? 1 : 0;

                if(sections[item]) {
                    switch(show_count) {
                        case 1:
                            return 'lg:col-span-6';
                            break;
                        case 2:
                            return 'lg:col-span-3';
                            break;
                        case 3:
                            return item == 'notes' ? 'lg:col-span-6' : 'lg:col-span-3';
                            break;
                        case 4:
                            return 'lg:col-span-3';
                            break;
                    }
                }

            },
            updateMonster() {
                let form = this.$inertia.form({
                    id: this.monster.id,
                    name: this.monster.name,
                    speed: this.monster.speed,
                    hp_max: this.monster.hp_max,
                    hp_current: this.monster.hp_current,
                    hp_temp: this.monster.hp_temp,
                    hit_dice: this.monster.hit_dice,
                    ac: this.monster.ac,
                    ac_source: this.monster.ac_source,
                    initiative: this.monster.initiative,
                    strength: this.monster.strength,
                    strength_save: this.monster.strength_save,
                    strength_mod: this.monster.strength_mod,
                    strength_save_proficiency: this.monster.strength_save_proficiency,
                    athletics: this.monster.athletics,
                    athletics_proficiency: this.monster.athletics_proficiency,
                    athletics_expertise: this.monster.athletics_expertise,
                    dexterity: this.monster.dexterity,
                    dexterity_save: this.monster.dexterity_save,
                    dexterity_mod: this.monster.dexterity_mod,
                    dexterity_save_proficiency: this.monster.dexterity_save_proficiency,
                    acrobatics: this.monster.acrobatics,
                    acrobatics_proficiency: this.monster.acrobatics_proficiency,
                    acrobatics_expertise: this.monster.acrobatics_expertise,
                    sleight_of_hand: this.monster.sleight_of_hand,
                    sleight_of_hand_proficiency: this.monster.sleight_of_hand_proficiency,
                    sleight_of_hand_expertise: this.monster.sleight_of_hand_expertise,
                    stealth: this.monster.stealth,
                    stealth_proficiency: this.monster.stealth_proficiency,
                    stealth_expertise: this.monster.stealth_expertise,
                    constitution: this.monster.constitution,
                    constitution_save: this.monster.constitution_save,
                    constitution_mod: this.monster.constitution_mod,
                    constitution_save_proficiency: this.monster.constitution_save_proficiency,
                    intelligence: this.monster.intelligence,
                    intelligence_save: this.monster.intelligence_save,
                    intelligence_mod: this.monster.intelligence_mod,
                    intelligence_save_proficiency: this.monster.intelligence_save_proficiency,
                    arcana: this.monster.arcana,
                    arcana_proficiency: this.monster.arcana_proficiency,
                    arcana_expertise: this.monster.arcana_expertise,
                    history: this.monster.history,
                    history_proficiency: this.monster.history_proficiency,
                    history_expertise: this.monster.history_expertise,
                    investigation: this.monster.investigation,
                    investigation_proficiency: this.monster.investigation_proficiency,
                    investigation_expertise: this.monster.investigation_expertise,
                    nature: this.monster.nature,
                    nature_proficiency: this.monster.nature_proficiency,
                    nature_expertise: this.monster.nature_expertise,
                    religion: this.monster.religion,
                    religion_proficiency: this.monster.religion_proficiency,
                    religion_expertise: this.monster.religion_expertise,
                    wisdom: this.monster.wisdom,
                    wisdom_save: this.monster.wisdom_save,
                    wisdom_mod: this.monster.wisdom_mod,
                    wisdom_save_proficiency: this.monster.wisdom_save_proficiency,
                    animal_handling: this.monster.animal_handling,
                    animal_handling_proficiency: this.monster.animal_handling_proficiency,
                    animal_handling_expertise: this.monster.animal_handling_expertise,
                    insight: this.monster.insight,
                    insight_proficiency: this.monster.insight_proficiency,
                    insight_expertise: this.monster.insight_expertise,
                    medicine: this.monster.medicine,
                    medicine_proficiency: this.monster.medicine_proficiency,
                    medicine_expertise: this.monster.medicine_expertise,
                    perception: this.monster.perception,
                    perception_proficiency: this.monster.perception_proficiency,
                    perception_expertise: this.monster.perception_expertise,
                    survival: this.monster.survival,
                    survival_proficiency: this.monster.survival_proficiency,
                    survival_expertise: this.monster.survival_expertise,
                    charisma: this.monster.charisma,
                    charisma_save: this.monster.charisma_save,
                    charisma_mod: this.monster.charisma_mod,
                    charisma_save_proficiency: this.monster.charisma_save_proficiency,
                    deception: this.monster.deception,
                    deception_proficiency: this.monster.deception_proficiency,
                    deception_expertise: this.monster.deception_expertise,
                    intimidation: this.monster.intimidation,
                    intimidation_proficiency: this.monster.intimidation_proficiency,
                    intimidation_expertise: this.monster.intimidation_expertise,
                    performance: this.monster.performance,
                    performance_proficiency: this.monster.performance_proficiency,
                    performance_expertise: this.monster.performance_expertise,
                    persuasion: this.monster.persuasion,
                    persuasion_proficiency: this.monster.persuasion_proficiency,
                    persuasion_expertise: this.monster.persuasion_expertise,
                    skills_auto_filled: this.monster.skills_auto_filled,
                    special_skill_modifiers: this.monster.special_skill_modifiers,
                    spellcaster: this.monster.spellcaster,
                    spell_type: this.monster.spell_type,
                    spell_dc: this.monster.spell_dc,
                    spell_level: this.monster.spell_level,
                    spell_points_max: this.monster.spell_points_max,
                    spell_points_current: this.monster.spell_points_current,
                    spell_recover: this.monster.spell_recover,
                    spell_list_type: this.monster.spell_list_type,
                    spell_slots_1: this.monster.spell_slots_1,
                    spell_slots_2: this.monster.spell_slots_2,
                    spell_slots_3: this.monster.spell_slots_3,
                    spell_slots_4: this.monster.spell_slots_4,
                    spell_slots_5: this.monster.spell_slots_5,
                    spell_slots_6: this.monster.spell_slots_6,
                    spell_slots_7: this.monster.spell_slots_7,
                    spell_slots_8: this.monster.spell_slots_8,
                    spell_slots_9: this.monster.spell_slots_9,
                    spell_list_0: this.monster.spell_list_0,
                    spell_list_1: this.monster.spell_list_1,
                    spell_list_2: this.monster.spell_list_2,
                    spell_list_3: this.monster.spell_list_3,
                    spell_list_4: this.monster.spell_list_4,
                    spell_list_5: this.monster.spell_list_5,
                    spell_list_6: this.monster.spell_list_6,
                    spell_list_7: this.monster.spell_list_7,
                    spell_list_8: this.monster.spell_list_8,
                    spell_list_9: this.monster.spell_list_9,
                    spell_prepare_count: this.monster.spell_prepare_count,
                    spell_prepared: this.monster.spell_prepared,
                    notes: this.monster.notes,
                    show_modifiers: this.monster.show_modifiers,
                    show_resources: this.monster.show_resources,
                    show_notes: this.monster.show_notes,
                    show_dice: this.monster.show_dice,
                    // monster fields
                    size: this.monster.size,
                    type: this.monster.type,
                    alignment: this.monster.alignment,
                    damage_vulnerabilities: this.monster.damage_vulnerabilities,
                    damage_resistances: this.monster.damage_resistances,
                    damage_immunities: this.monster.damage_immunities,
                    condition_immunities: this.monster.condition_immunities,
                    senses: this.monster.senses,
                    languages: this.monster.languages,
                    challenge_rating: this.monster.challenge_rating,
                    experience: this.monster.experience,
                    source: this.monster.source,
                    public: this.monster.public,
                });

                form.patch(route('monsters.update', form.id), {
                    preserveState: true,
                    // preserveScroll: true,
                });
            },
        }
    }
</script>
