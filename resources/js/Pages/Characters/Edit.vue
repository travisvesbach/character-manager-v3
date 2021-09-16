<template>
    <app-layout :title="editing && editing.name ? 'Edit ' + editing.name : 'Create Character'">
        <template #header>
            {{ editing && editing.name ? 'Edit ' + editing.name : 'Create Character' }}
        </template>

        <centered-form @submitted="submit" width="full">

            <div>
                <h3 class="text-2xl font-bold inline-block heading-color">Basic Info</h3>
                <div class="md:flex items-top mt-5">
                    <div class="md:w-1/2 pr-1.5">
                        <!-- Name -->
                        <jet-label for="name" value="Name" />
                        <jet-input type="text" id="name" class="mt-1 block w-full" v-model="form.name" required/>
                        <jet-input-error :message="form.errors.name" class="mt-2" />

                        <!-- Race -->
                        <jet-label for="race" value="Race" class="mt-4" />
                        <jet-input type="text" id="race" class="mt-1 block w-full" v-model="form.race" required/>
                        <jet-input-error :message="form.errors.race" class="mt-2" />

                        <!-- Class -->
                        <jet-label for="class" value="Class" class="mt-4" />
                        <jet-input type="text" id="class" class="mt-1 block w-full" v-model="form.class" required/>
                        <jet-input-error :message="form.errors.class" class="mt-2" />

                        <!-- level -->
                        <jet-label for="level" value="Level" class="mt-4" />
                        <jet-input type="number" id="level" class="mt-1 block w-full" v-model.number="form.level" @input="setSkills()" required/>
                        <jet-input-error :message="form.errors.level" class="mt-2" />

                        <!-- speed -->
                        <jet-label for="speed" value="Speed" class="mt-4" />
                        <jet-input type="text" id="speed" class="mt-1 block w-full" v-model="form.speed" required/>
                        <jet-input-error :message="form.errors.speed" class="mt-2" />
                    </div>

                    <div class="md:w-1/2 pl-1.5">
                        <!-- max_hp -->
                        <jet-label for="max_hp" value="Max HP" />
                        <jet-input type="number" id="max_hp" class="mt-1 block w-full" v-model.number="form.max_hp" @input="form.current_hp = $event.target.value" required/>
                        <jet-input-error :message="form.errors.max_hp" class="mt-2" />

                        <!-- hit_dice -->
                        <jet-label for="hit_dice" value="Hit Dice" class="mt-4" />
                        <dice-array-input v-model="form.hit_dice" :current="true" />
                        <jet-input-error :message="form.errors.max_hp" class="mt-2" />

                        <!-- ac -->
                        <jet-label for="ac" value="AC" class="mt-4" />
                        <jet-input type="number" id="ac" class="mt-1 block w-full" v-model.number="form.ac" required/>
                        <jet-input-error :message="form.errors.ac" class="mt-2" />

                        <!-- ac_source -->
                        <jet-label for="ac_source" value="AC Source" class="mt-4" />
                        <jet-input type="text" id="ac_source" class="mt-1 block w-full" v-model="form.ac_source" required/>
                        <jet-input-error :message="form.errors.ac_source" class="mt-2" />

                        <!-- initiative -->
                        <jet-label for="initiative" value="Initiative" class="mt-4" />
                        <jet-input type="number" id="initiative" class="mt-1 block w-full" v-model.number="form.initiative" required/>
                        <jet-input-error :message="form.errors.initiative" class="mt-2" />

                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-10 pt-2">
                <h3 class="text-2xl font-bold inline-block heading-color">Stats and Proficiencies</h3>
                <p>
                    Enter stats and mark skill proficiencies and/or expertise. The first checkbox of each skill is proficiency and the second is expertise.
                </p>
                <div class="flex items-top mt-5">
                    <div class="md:w-1/3 pr-1.5" v-on:change="setSkills('strength')">
                        <!-- strength -->
                        <jet-label for="strength" value="Strength Score" />
                        <jet-input type="number" id="strength" class="mt-1 block w-full" v-model.number="form.strength" required/>
                        <jet-input-error :message="form.errors.strength" class="mt-2" />

                        <proficiency-checkbox label="Save" slug="strength_save" v-model:proficiency="form.strength_save_proficiency" />
                        <proficiency-checkbox label="Athletics" v-model:proficiency="form.athletics_proficiency" v-model:expertise="form.athletics_expertise"/>
                    </div>
                    <div class="md:w-1/3 px-1.5" v-on:change="setSkills('dexterity')">
                        <!-- dexterity -->
                        <jet-label for="dexterity" value="Dexterity Score" />
                        <jet-input type="number" id="dexterity" class="mt-1 block w-full" v-model.number="form.dexterity" required/>
                        <jet-input-error :message="form.errors.dexterity" class="mt-2" />

                        <proficiency-checkbox label="Save" slug="dexterity_save" v-model:proficiency="form.dexterity_save_proficiency" />
                        <proficiency-checkbox label="Acrobatics" v-model:proficiency="form.acrobatics_proficiency" v-model:expertise="form.acrobatics_expertise"/>
                        <proficiency-checkbox label="Sleightof Hand" v-model:proficiency="form.sleight_of_hand_proficiency" v-model:expertise="form.sleight_of_hand_expertise"/>
                        <proficiency-checkbox label="Stealth" v-model:proficiency="form.stealth_proficiency" v-model:expertise="form.stealth_expertise"/>
                    </div>
                    <div class="md:w-1/3 pl-1.5" v-on:change="setSkills('constitution')">
                        <!-- constitution -->
                        <jet-label for="constitution" value="Constitution Score" />
                        <jet-input type="number" id="constitution" class="mt-1 block w-full" v-model.number="form.constitution" required/>
                        <jet-input-error :message="form.errors.constitution" class="mt-2" />

                        <proficiency-checkbox label="Save" slug="constitution_save" v-model:proficiency="form.constitution_save_proficiency" />
                    </div>
                </div>

                <div class="flex items-top mt-10">
                    <div class="md:w-1/3 pr-1.5" v-on:change="setSkills('intelligence')">
                        <!-- intelligence -->
                        <jet-label for="intelligence" value="Intelligence Score" />
                        <jet-input type="number" id="intelligence" class="mt-1 block w-full" v-model.number="form.intelligence" required/>
                        <jet-input-error :message="form.errors.intelligence" class="mt-2" />

                        <proficiency-checkbox label="Save" slug="intelligence_save" v-model:proficiency="form.intelligence_save_proficiency" />
                        <proficiency-checkbox label="Arcana" v-model:proficiency="form.arcana_proficiency" v-model:expertise="form.arcana_expertise"/>
                        <proficiency-checkbox label="History" v-model:proficiency="form.history_proficiency" v-model:expertise="form.history_expertise"/>
                        <proficiency-checkbox label="Investigation" v-model:proficiency="form.investigation_proficiency" v-model:expertise="form.investigation_expertise"/>
                        <proficiency-checkbox label="Nature" v-model:proficiency="form.nature_proficiency" v-model:expertise="form.nature_expertise"/>
                        <proficiency-checkbox label="Religion" v-model:proficiency="form.religion_proficiency" v-model:expertise="form.religion_expertise"/>
                    </div>
                    <div class="md:w-1/3 px-1.5" v-on:change="setSkills('wisdom')">
                        <!-- wisdom -->
                        <jet-label for="wisdom" value="Wisdom Score" />
                        <jet-input type="number" id="wisdom" class="mt-1 block w-full" v-model.number="form.wisdom" required/>
                        <jet-input-error :message="form.errors.wisdom" class="mt-2" />

                        <proficiency-checkbox label="Save" slug="wisdom_save" v-model:proficiency="form.wisdom_save_proficiency" />
                        <proficiency-checkbox label="Animal Handling" v-model:proficiency="form.animal_handling_proficiency" v-model:expertise="form.animal_handling_expertise"/>
                        <proficiency-checkbox label="Insight" v-model:proficiency="form.insight_proficiency" v-model:expertise="form.insight_expertise"/>
                        <proficiency-checkbox label="Medicine" v-model:proficiency="form.medicine_proficiency" v-model:expertise="form.medicine_expertise"/>
                        <proficiency-checkbox label="Perception" v-model:proficiency="form.perception_proficiency" v-model:expertise="form.perception_expertise"/>
                        <proficiency-checkbox label="Survival" v-model:proficiency="form.survival_proficiency" v-model:expertise="form.survival_expertise"/>
                    </div>
                    <div class="md:w-1/3 pl-1.5" v-on:change="setSkills('charisma')">
                        <!-- charisma -->
                        <jet-label for="charisma" value="Charisma Score" />
                        <jet-input type="number" id="charisma" class="mt-1 block w-full" v-model.number="form.charisma" required/>
                        <jet-input-error :message="form.errors.charisma" class="mt-2" />

                        <proficiency-checkbox label="Save" slug="charisma_save" v-model:proficiency="form.charisma_save_proficiency" />
                        <proficiency-checkbox label="Deception" v-model:proficiency="form.deception_proficiency" v-model:expertise="form.deception_expertise"/>
                        <proficiency-checkbox label="Intimidation" v-model:proficiency="form.intimidation_proficiency" v-model:expertise="form.intimidation_expertise"/>
                        <proficiency-checkbox label="Performance" v-model:proficiency="form.performance_proficiency" v-model:expertise="form.performance_expertise"/>
                        <proficiency-checkbox label="Persuasion" v-model:proficiency="form.persuasion_proficiency" v-model:expertise="form.persuasion_expertise"/>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-10 pt-2">
                <div class="flex items-center">
                    <h3 class="text-2xl font-bold inline-block heading-color">Skill Modifiers</h3>
                    <jet-secondary-button type="button" class="ml-5" @click.prevent="toggleAutoSkills">
                        {{ skillsButtonText }}
                    </jet-secondary-button>
                </div>
                <p>
                    {{ skillsText }}
                </p>
                <div v-if="!form.skills_auto_filled">
                    <div class="flex items-top mt-5">
                        <div class="md:w-1/3 pr-1.5">
                            <!-- strength -->
                            <jet-label for="strength_save" value="Strength Save" />
                            <jet-input type="number" id="strength_save" class="mt-1 block w-full" v-model.number="form.strength_save" required/>
                            <jet-input-error :message="form.errors.strength_save" class="mt-2" />

                            <jet-label for="athletics" value="Athletics" />
                            <jet-input type="number" id="athletics" class="mt-1 block w-full" v-model.number="form.athletics" required/>
                            <jet-input-error :message="form.errors.athletics" class="mt-2" />
                        </div>
                        <div class="md:w-1/3 px-1.5">
                            <!-- dexterity -->
                            <jet-label for="dexterity_save" value="Dexterity Save" />
                            <jet-input type="number" id="dexterity_save" class="mt-1 block w-full" v-model.number="form.dexterity_save" required/>
                            <jet-input-error :message="form.errors.dexterity_save" class="mt-2" />

                            <jet-label for="acrobatics" value="Acrobatics" />
                            <jet-input type="number" id="acrobatics" class="mt-1 block w-full" v-model.number="form.acrobatics" required/>
                            <jet-input-error :message="form.errors.acrobatics" class="mt-2" />

                            <jet-label for="sleight_of_hand" value="Sleight of Hand" />
                            <jet-input type="number" id="sleight_of_hand" class="mt-1 block w-full" v-model.number="form.sleight_of_hand" required/>
                            <jet-input-error :message="form.errors.sleight_of_hand" class="mt-2" />

                            <jet-label for="stealth" value="Stealth" />
                            <jet-input type="number" id="stealth" class="mt-1 block w-full" v-model.number="form.stealth" required/>
                            <jet-input-error :message="form.errors.stealth" class="mt-2" />

                        </div>
                        <div class="md:w-1/3 pl-1.5">
                            <!-- constitution -->
                            <jet-label for="constitution_save" value="Constitution Save" />
                            <jet-input type="number" id="constitution_save" class="mt-1 block w-full" v-model.number="form.constitution_save" required/>
                            <jet-input-error :message="form.errors.constitution_save" class="mt-2" />

                        </div>
                    </div>

                    <div class="flex items-top mt-10">
                        <div class="md:w-1/3 pr-1.5">
                            <!-- intelligence -->
                            <jet-label for="intelligence_save" value="Intelligence Save" />
                            <jet-input type="number" id="intelligence_save" class="mt-1 block w-full" v-model.number="form.intelligence_save" required/>
                            <jet-input-error :message="form.errors.intelligence_save" class="mt-2" />

                            <jet-label for="arcana" value="Arcana" />
                            <jet-input type="number" id="arcana" class="mt-1 block w-full" v-model.number="form.arcana" required/>
                            <jet-input-error :message="form.errors.arcana" class="mt-2" />

                            <jet-label for="history" value="History" />
                            <jet-input type="number" id="history" class="mt-1 block w-full" v-model.number="form.history" required/>
                            <jet-input-error :message="form.errors.history" class="mt-2" />

                            <jet-label for="investigation" value="Investigation" />
                            <jet-input type="number" id="investigation" class="mt-1 block w-full" v-model.number="form.investigation" required/>
                            <jet-input-error :message="form.errors.investigation" class="mt-2" />

                            <jet-label for="nature" value="Nature" />
                            <jet-input type="number" id="nature" class="mt-1 block w-full" v-model.number="form.nature" required/>
                            <jet-input-error :message="form.errors.nature" class="mt-2" />

                            <jet-label for="religion" value="Religion" />
                            <jet-input type="number" id="religion" class="mt-1 block w-full" v-model.number="form.religion" required/>
                            <jet-input-error :message="form.errors.religion" class="mt-2" />

                        </div>
                        <div class="md:w-1/3 px-1.5">
                            <!-- wisdom -->
                            <jet-label for="wisdom_save" value="Wisdom Save" />
                            <jet-input type="number" id="wisdom_save" class="mt-1 block w-full" v-model.number="form.wisdom_save" required/>
                            <jet-input-error :message="form.errors.wisdom_save" class="mt-2" />

                            <jet-label for="animal_handling" value="Animal Handling" />
                            <jet-input type="number" id="animal_handling" class="mt-1 block w-full" v-model.number="form.animal_handling" required/>
                            <jet-input-error :message="form.errors.animal_handling" class="mt-2" />

                            <jet-label for="insight" value="Insight" />
                            <jet-input type="number" id="insight" class="mt-1 block w-full" v-model.number="form.insight" required/>
                            <jet-input-error :message="form.errors.insight" class="mt-2" />

                            <jet-label for="medicine" value="Medicine" />
                            <jet-input type="number" id="medicine" class="mt-1 block w-full" v-model.number="form.medicine" required/>
                            <jet-input-error :message="form.errors.medicine" class="mt-2" />

                            <jet-label for="perception" value="Perception" />
                            <jet-input type="number" id="perception" class="mt-1 block w-full" v-model.number="form.perception" required/>
                            <jet-input-error :message="form.errors.perception" class="mt-2" />

                            <jet-label for="survival" value="Survival" />
                            <jet-input type="number" id="survival" class="mt-1 block w-full" v-model.number="form.survival" required/>
                            <jet-input-error :message="form.errors.survival" class="mt-2" />

                        </div>
                        <div class="md:w-1/3 pl-1.5">
                            <!-- charisma -->
                            <jet-label for="charisma_save" value="Charisma Save" />
                            <jet-input type="number" id="charisma_save" class="mt-1 block w-full" v-model.number="form.charisma_save" required/>
                            <jet-input-error :message="form.errors.charisma_save" class="mt-2" />

                            <jet-label for="deception" value="Deception" />
                            <jet-input type="number" id="deception" class="mt-1 block w-full" v-model.number="form.deception" required/>
                            <jet-input-error :message="form.errors.deception" class="mt-2" />

                            <jet-label for="intimidation" value="Intimidation" />
                            <jet-input type="number" id="intimidation" class="mt-1 block w-full" v-model.number="form.intimidation" required/>
                            <jet-input-error :message="form.errors.intimidation" class="mt-2" />

                            <jet-label for="performance" value="Performance" />
                            <jet-input type="number" id="performance" class="mt-1 block w-full" v-model.number="form.performance" required/>
                            <jet-input-error :message="form.errors.performance" class="mt-2" />

                            <jet-label for="persuasion" value="Persuasion" />
                            <jet-input type="number" id="persuasion" class="mt-1 block w-full" v-model.number="form.persuasion" required/>
                            <jet-input-error :message="form.errors.persuasion" class="mt-2" />

                        </div>
                    </div>
                </div>
            </div>

            <template #actions>
                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                    Saved.
                </jet-action-message>
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </jet-button>
            </template>

        </centered-form>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import CenteredForm from '@/Components/CenteredForm'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import SelectInput from '@/Components/SelectInput'
    import ProficiencyCheckbox from '@/Components/ProficiencyCheckbox'
    import DiceArrayInput from '@/Components/DiceArrayInput'

    import { creatureEdit } from '@/Mixins/Creature/Edit';

    export default {
        props: ['editing'],

        components: {
            AppLayout,
            JetActionMessage,
            JetButton,
            JetSecondaryButton,
            CenteredForm,
            JetInput,
            JetInputError,
            JetLabel,
            SelectInput,
            ProficiencyCheckbox,
            DiceArrayInput,
        },
        mixins: [creatureEdit],
        created() {
            if(this.editing) {
                this.form.race = this.editing.race;
                this.form.class = this.editing.class;
                this.form.level = this.editing.level;
            }
        },
        methods: {
            submit() {
                if(this.editing) {
                    this.form.patch(route('characters.update', this.form.id));
                } else {
                    this.form.post(route('characters.store'));
                }
            },
        },
    }
</script>
