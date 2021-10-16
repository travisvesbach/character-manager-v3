<template>
    <app-layout :title="creature && creature.name ? 'Edit ' + creature.name : 'Create ' + type">
        <template #header>
            {{ creature && creature.name ? 'Edit ' + creature.name : 'Create ' + type }}
        </template>

        <centered-form @submitted="submit" width="full">
            <div>
                <h3 class="text-2xl font-bold inline-block heading-color">Basic Info</h3>
                <div class="grid sm:grid-cols-2">
                    <div class="col-span-1 px-1">
                        <!-- Name -->
                        <jet-label for="name" value="Name" class="mt-4"/>
                        <jet-input type="text" id="name" class="mt-1 w-full" v-model="form.name" required/>
                        <jet-input-error :message="form.errors.name" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1" v-if="type == 'Character'">
                        <!-- Race -->
                        <jet-label for="race" value="Race" class="mt-4"/>
                        <jet-input type="text" id="race" class="mt-1 w-full" placeholder="Human" v-model="form.race" required/>
                        <jet-input-error :message="form.errors.race" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1" v-if="type == 'Character'">
                        <!-- Class -->
                        <jet-label for="class" value="Class" class="mt-4"/>
                        <jet-input type="text" id="class" class="mt-1 w-full" placeholder="Fighter" v-model="form.class" required/>
                        <jet-input-error :message="form.errors.class" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1" v-if="type == 'Character'">
                        <!-- level -->
                        <jet-label for="level" value="Level" class="mt-4"/>
                        <jet-input type="number" id="level" class="mt-1 w-full" v-model.number="form.level" @input="setSkills()" required/>
                        <jet-input-error :message="form.errors.level" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1" v-if="type == 'Monster'">
                        <!-- size -->
                        <jet-label for="race" value="Size" class="mt-4"/>
                        <jet-input type="text" id="size" class="mt-1 w-full" placeholder="Large" v-model="form.size" required/>
                        <jet-input-error :message="form.errors.size" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1" v-if="type == 'Monster'">
                        <!-- type -->
                        <jet-label for="type" value="Type" class="mt-4"/>
                        <jet-input type="text" id="type" class="mt-1 w-full" placeholder="Beast" v-model="form.type" required/>
                        <jet-input-error :message="form.errors.type" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1" v-if="type == 'Monster'">
                        <!-- alignment -->
                        <jet-label for="alignment" value="Alignment" class="mt-4"/>
                        <jet-input type="text" id="alignment" class="mt-1 w-full" placeholder="unaligned" v-model="form.alignment" required/>
                        <jet-input-error :message="form.errors.alignment" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- speed -->
                        <jet-label for="speed" value="Speed" class="mt-4"/>
                        <jet-input type="text" id="speed" class="mt-1 w-full" placeholder="30 ft." v-model="form.speed" required/>
                        <jet-input-error :message="form.errors.speed" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- initiative -->
                        <jet-label for="initiative" value="Initiative" class="mt-4"/>
                        <jet-input type="number" id="initiative" class="mt-1 w-full" v-model.number="form.initiative" required/>
                        <jet-input-error :message="form.errors.initiative" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- hp_max -->
                        <jet-label for="hp_max" value="Max HP" class="mt-4"/>
                        <jet-input type="number" id="hp_max" class="mt-1 w-full" v-model.number="form.hp_max" @input="form.hp_current = $event.target.value" required/>
                        <jet-input-error :message="form.errors.hp_max" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- hit_dice -->
                        <jet-label for="hit_dice" value="Hit Dice" class="mt-4"/>
                        <dice-array-input v-model="form.hit_dice" :current="true" :multiple="true"/>
                        <jet-input-error :message="form.errors.hit_dice" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- ac -->
                        <jet-label for="ac" value="AC" class="mt-4"/>
                        <jet-input type="number" id="ac" class="mt-1 w-full" v-model.number="form.ac" required/>
                        <jet-input-error :message="form.errors.ac" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- ac_source -->
                        <jet-label for="ac_source" value="AC Source" class="mt-4"/>
                        <jet-input type="text" id="ac_source" class="mt-1 w-full" placeholder="leather armor" v-model="form.ac_source" required/>
                        <jet-input-error :message="form.errors.ac_source" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- damage_vulnerabilities -->
                        <jet-label for="damage_vulnerabilities" value="Damage Vulnerabilities" class="mt-4"/>
                        <jet-input type="text" id="damage_vulnerabilities" class="mt-1 w-full" placeholder="fire" v-model="form.damage_vulnerabilities"/>
                        <jet-input-error :message="form.errors.damage_vulnerabilities" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- damage_resistances -->
                        <jet-label for="damage_resistances" value="Damage Resistances" class="mt-4"/>
                        <jet-input type="text" id="damage_resistances" class="mt-1 w-full" placeholder="fire" v-model="form.damage_resistances"/>
                        <jet-input-error :message="form.errors.damage_resistances" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- damage_immunities -->
                        <jet-label for="damage_immunities" value="Damage Immunities" class="mt-4"/>
                        <jet-input type="text" id="damage_immunities" class="mt-1 w-full" placeholder="fire" v-model="form.damage_immunities"/>
                        <jet-input-error :message="form.errors.damage_immunities" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- condition_immunities -->
                        <jet-label for="condition_immunities" value="Condition Immunities" class="mt-4"/>
                        <jet-input type="text" id="condition_immunities" class="mt-1 w-full" placeholder="poisoned" v-model="form.condition_immunities"/>
                        <jet-input-error :message="form.errors.condition_immunities" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- languages -->
                        <jet-label for="languages" value="Languages" class="mt-4"/>
                        <jet-input type="text" id="languages" class="mt-1 w-full" placeholder="Common" v-model="form.languages"/>
                        <jet-input-error :message="form.errors.languages" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1">
                        <!-- senses -->
                        <jet-label for="senses" value="Senses" class="mt-4"/>
                        <jet-input type="text" id="senses" class="mt-1 w-full" placeholder="Darkvision: 60 ft." v-model="form.senses"/>
                        <jet-input-error :message="form.errors.senses" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1" v-if="type == 'Monster'">
                        <!-- challenge_rating -->
                        <jet-label for="challenge_rating" value="Challenge Rating" class="mt-4"/>
                        <jet-input type="text" id="challenge_rating" class="mt-1 w-full" placeholder="1/2" v-model="form.challenge_rating" @input="setSkills()" required/>
                        <jet-input-error :message="form.errors.alignment" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1" v-if="type == 'Monster'">
                        <!-- experience -->
                        <jet-label for="experience" value="Experience" class="mt-4"/>
                        <jet-input type="number" id="experience" class="mt-1 w-full" placeholder="50" v-model.number="form.experience" required/>
                        <jet-input-error :message="form.errors.alignment" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1" v-if="type == 'Monster'">
                        <!-- source -->
                        <jet-label for="source" value="Source" class="mt-4"/>
                        <jet-input type="text" id="source" class="mt-1 w-full" placeholder="Monster Manual p341" v-model="form.source" required/>
                        <jet-input-error :message="form.errors.alignment" class="mt-2"/>
                    </div>
                    <div class="col-span-1 px-1" v-if="type == 'Monster'">
                        <!-- public -->
                        <jet-label for="public" value="Visibility" class="mt-4"/>
                        <select-input id="public" class="mt-1 w-full" v-model="form.public" :options="[[1, 'Public'], [0, 'Private']]"/>
                        <jet-input-error :message="form.errors.public" class="mt-2"/>
                    </div>
                </div>
            </div>

            <div class="border-t dark:border-gray-600 mt-10 pt-2">
                <h3 class="text-2xl font-bold inline-block heading-color">Stats and Proficiencies</h3>
                <p>
                    Enter stats and mark skill proficiencies and/or expertise. The first checkbox of each skill is proficiency and the second is expertise.
                </p>
                <div class="grid sm:grid-cols-2 md:grid-cols-3">
                    <div class="col-span-1 mb-10 px-1" v-on:change="setSkills('strength')">
                        <!-- strength -->
                        <jet-label for="strength" value="Strength Score" class="mt-4"/>
                        <jet-input type="number" id="strength" class="mt-1 block w-full" v-model.number="form.strength" required/>
                        <jet-input-error :message="form.errors.strength" class="mt-2"/>

                        <proficiency-checkbox label="Save" slug="strength_save" v-model:proficiency="form.strength_save_proficiency" />
                        <proficiency-checkbox label="Athletics" v-model:proficiency="form.athletics_proficiency" v-model:expertise="form.athletics_expertise"/>
                    </div>
                    <div class="col-span-1 mb-10 px-1" v-on:change="setSkills('dexterity')">
                        <!-- dexterity -->
                        <jet-label for="dexterity" value="Dexterity Score" class="mt-4"/>
                        <jet-input type="number" id="dexterity" class="mt-1 block w-full" v-model.number="form.dexterity" required/>
                        <jet-input-error :message="form.errors.dexterity" class="mt-2"/>

                        <proficiency-checkbox label="Save" slug="dexterity_save" v-model:proficiency="form.dexterity_save_proficiency" />
                        <proficiency-checkbox label="Acrobatics" v-model:proficiency="form.acrobatics_proficiency" v-model:expertise="form.acrobatics_expertise"/>
                        <proficiency-checkbox label="Sleightof Hand" v-model:proficiency="form.sleight_of_hand_proficiency" v-model:expertise="form.sleight_of_hand_expertise"/>
                        <proficiency-checkbox label="Stealth" v-model:proficiency="form.stealth_proficiency" v-model:expertise="form.stealth_expertise"/>
                    </div>
                    <div class="col-span-1 mb-10 px-1" v-on:change="setSkills('constitution')">
                        <!-- constitution -->
                        <jet-label for="constitution" value="Constitution Score" class="mt-4"/>
                        <jet-input type="number" id="constitution" class="mt-1 block w-full" v-model.number="form.constitution" required/>
                        <jet-input-error :message="form.errors.constitution" class="mt-2"/>

                        <proficiency-checkbox label="Save" slug="constitution_save" v-model:proficiency="form.constitution_save_proficiency" />
                    </div>
                    <div class="col-span-1 mb-10 px-1" v-on:change="setSkills('intelligence')">
                        <!-- intelligence -->
                        <jet-label for="intelligence" value="Intelligence Score" class="mt-4"/>
                        <jet-input type="number" id="intelligence" class="mt-1 block w-full" v-model.number="form.intelligence" required/>
                        <jet-input-error :message="form.errors.intelligence" class="mt-2"/>

                        <proficiency-checkbox label="Save" slug="intelligence_save" v-model:proficiency="form.intelligence_save_proficiency" />
                        <proficiency-checkbox label="Arcana" v-model:proficiency="form.arcana_proficiency" v-model:expertise="form.arcana_expertise"/>
                        <proficiency-checkbox label="History" v-model:proficiency="form.history_proficiency" v-model:expertise="form.history_expertise"/>
                        <proficiency-checkbox label="Investigation" v-model:proficiency="form.investigation_proficiency" v-model:expertise="form.investigation_expertise"/>
                        <proficiency-checkbox label="Nature" v-model:proficiency="form.nature_proficiency" v-model:expertise="form.nature_expertise"/>
                        <proficiency-checkbox label="Religion" v-model:proficiency="form.religion_proficiency" v-model:expertise="form.religion_expertise"/>
                    </div>
                    <div class="col-span-1 mb-10 px-1" v-on:change="setSkills('wisdom')">
                        <!-- wisdom -->
                        <jet-label for="wisdom" value="Wisdom Score" class="mt-4"/>
                        <jet-input type="number" id="wisdom" class="mt-1 block w-full" v-model.number="form.wisdom" required/>
                        <jet-input-error :message="form.errors.wisdom" class="mt-2"/>

                        <proficiency-checkbox label="Save" slug="wisdom_save" v-model:proficiency="form.wisdom_save_proficiency" />
                        <proficiency-checkbox label="Animal Handling" v-model:proficiency="form.animal_handling_proficiency" v-model:expertise="form.animal_handling_expertise"/>
                        <proficiency-checkbox label="Insight" v-model:proficiency="form.insight_proficiency" v-model:expertise="form.insight_expertise"/>
                        <proficiency-checkbox label="Medicine" v-model:proficiency="form.medicine_proficiency" v-model:expertise="form.medicine_expertise"/>
                        <proficiency-checkbox label="Perception" v-model:proficiency="form.perception_proficiency" v-model:expertise="form.perception_expertise"/>
                        <proficiency-checkbox label="Survival" v-model:proficiency="form.survival_proficiency" v-model:expertise="form.survival_expertise"/>
                    </div>
                    <div class="col-span-1 mb-10 px-1" v-on:change="setSkills('charisma')">
                        <!-- charisma -->
                        <jet-label for="charisma" value="Charisma Score" class="mt-4"/>
                        <jet-input type="number" id="charisma" class="mt-1 block w-full" v-model.number="form.charisma" required/>
                        <jet-input-error :message="form.errors.charisma" class="mt-2"/>

                        <proficiency-checkbox label="Save" slug="charisma_save" v-model:proficiency="form.charisma_save_proficiency" />
                        <proficiency-checkbox label="Deception" v-model:proficiency="form.deception_proficiency" v-model:expertise="form.deception_expertise"/>
                        <proficiency-checkbox label="Intimidation" v-model:proficiency="form.intimidation_proficiency" v-model:expertise="form.intimidation_expertise"/>
                        <proficiency-checkbox label="Performance" v-model:proficiency="form.performance_proficiency" v-model:expertise="form.performance_expertise"/>
                        <proficiency-checkbox label="Persuasion" v-model:proficiency="form.persuasion_proficiency" v-model:expertise="form.persuasion_expertise"/>
                    </div>
                </div>
            </div>

            <div class="border-t dark:border-gray-600 pt-2">
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
                    <div class="grid sm:grid-cols-2 md:grid-cols-3">
                        <div class="col-span-1 mb-10 px-1">
                            <!-- strength -->
                            <jet-label for="strength_save" value="Strength Save" class="mt-4"/>
                            <jet-input type="number" id="strength_save" class="mt-1 block w-full" v-model.number="form.strength_save" required/>
                            <jet-input-error :message="form.errors.strength_save" class="mt-2"/>

                            <jet-label for="athletics" value="Athletics" />
                            <jet-input type="number" id="athletics" class="mt-1 block w-full" v-model.number="form.athletics" required/>
                            <jet-input-error :message="form.errors.athletics" class="mt-2"/>
                        </div>
                        <div class="col-span-1 mb-10 px-1">
                            <!-- dexterity -->
                            <jet-label for="dexterity_save" value="Dexterity Save" class="mt-4"/>
                            <jet-input type="number" id="dexterity_save" class="mt-1 block w-full" v-model.number="form.dexterity_save" required/>
                            <jet-input-error :message="form.errors.dexterity_save" class="mt-2"/>

                            <jet-label for="acrobatics" value="Acrobatics" class="mt-4"/>
                            <jet-input type="number" id="acrobatics" class="mt-1 block w-full" v-model.number="form.acrobatics" required/>
                            <jet-input-error :message="form.errors.acrobatics" class="mt-2"/>

                            <jet-label for="sleight_of_hand" value="Sleight of Hand" class="mt-4"/>
                            <jet-input type="number" id="sleight_of_hand" class="mt-1 block w-full" v-model.number="form.sleight_of_hand" required/>
                            <jet-input-error :message="form.errors.sleight_of_hand" class="mt-2"/>

                            <jet-label for="stealth" value="Stealth" class="mt-4"/>
                            <jet-input type="number" id="stealth" class="mt-1 block w-full" v-model.number="form.stealth" required/>
                            <jet-input-error :message="form.errors.stealth" class="mt-2"/>

                        </div>
                        <div class="col-span-1 mb-10 px-1">
                            <!-- constitution -->
                            <jet-label for="constitution_save" value="Constitution Save" class="mt-4"/>
                            <jet-input type="number" id="constitution_save" class="mt-1 block w-full" v-model.number="form.constitution_save" required/>
                            <jet-input-error :message="form.errors.constitution_save" class="mt-2"/>

                        </div>
                        <div class="col-span-1 mb-10 px-1">
                            <!-- intelligence -->
                            <jet-label for="intelligence_save" value="Intelligence Save" class="mt-4"/>
                            <jet-input type="number" id="intelligence_save" class="mt-1 block w-full" v-model.number="form.intelligence_save" required/>
                            <jet-input-error :message="form.errors.intelligence_save" class="mt-2"/>

                            <jet-label for="arcana" value="Arcana" class="mt-4"/>
                            <jet-input type="number" id="arcana" class="mt-1 block w-full" v-model.number="form.arcana" required/>
                            <jet-input-error :message="form.errors.arcana" class="mt-2"/>

                            <jet-label for="history" value="History" class="mt-4"/>
                            <jet-input type="number" id="history" class="mt-1 block w-full" v-model.number="form.history" required/>
                            <jet-input-error :message="form.errors.history" class="mt-2"/>

                            <jet-label for="investigation" value="Investigation" class="mt-4"/>
                            <jet-input type="number" id="investigation" class="mt-1 block w-full" v-model.number="form.investigation" required/>
                            <jet-input-error :message="form.errors.investigation" class="mt-2"/>

                            <jet-label for="nature" value="Nature" class="mt-4"/>
                            <jet-input type="number" id="nature" class="mt-1 block w-full" v-model.number="form.nature" required/>
                            <jet-input-error :message="form.errors.nature" class="mt-2"/>

                            <jet-label for="religion" value="Religion" class="mt-4"/>
                            <jet-input type="number" id="religion" class="mt-1 block w-full" v-model.number="form.religion" required/>
                            <jet-input-error :message="form.errors.religion" class="mt-2"/>

                        </div>
                        <div class="col-span-1 mb-10 px-1">
                            <!-- wisdom -->
                            <jet-label for="wisdom_save" value="Wisdom Save" class="mt-4"/>
                            <jet-input type="number" id="wisdom_save" class="mt-1 block w-full" v-model.number="form.wisdom_save" required/>
                            <jet-input-error :message="form.errors.wisdom_save" class="mt-2"/>

                            <jet-label for="animal_handling" value="Animal Handling" class="mt-4"/>
                            <jet-input type="number" id="animal_handling" class="mt-1 block w-full" v-model.number="form.animal_handling" required/>
                            <jet-input-error :message="form.errors.animal_handling" class="mt-2"/>

                            <jet-label for="insight" value="Insight" class="mt-4"/>
                            <jet-input type="number" id="insight" class="mt-1 block w-full" v-model.number="form.insight" required/>
                            <jet-input-error :message="form.errors.insight" class="mt-2"/>

                            <jet-label for="medicine" value="Medicine" class="mt-4"/>
                            <jet-input type="number" id="medicine" class="mt-1 block w-full" v-model.number="form.medicine" required/>
                            <jet-input-error :message="form.errors.medicine" class="mt-2"/>

                            <jet-label for="perception" value="Perception" class="mt-4"/>
                            <jet-input type="number" id="perception" class="mt-1 block w-full" v-model.number="form.perception" required/>
                            <jet-input-error :message="form.errors.perception" class="mt-2"/>

                            <jet-label for="survival" value="Survival" class="mt-4"/>
                            <jet-input type="number" id="survival" class="mt-1 block w-full" v-model.number="form.survival" required/>
                            <jet-input-error :message="form.errors.survival" class="mt-2"/>

                        </div>
                        <div class="col-span-1 mb-10 px-1">
                            <!-- charisma -->
                            <jet-label for="charisma_save" value="Charisma Save" class="mt-4"/>
                            <jet-input type="number" id="charisma_save" class="mt-1 block w-full" v-model.number="form.charisma_save" required/>
                            <jet-input-error :message="form.errors.charisma_save" class="mt-2"/>

                            <jet-label for="deception" value="Deception" class="mt-4"/>
                            <jet-input type="number" id="deception" class="mt-1 block w-full" v-model.number="form.deception" required/>
                            <jet-input-error :message="form.errors.deception" class="mt-2"/>

                            <jet-label for="intimidation" value="Intimidation" class="mt-4"/>
                            <jet-input type="number" id="intimidation" class="mt-1 block w-full" v-model.number="form.intimidation" required/>
                            <jet-input-error :message="form.errors.intimidation" class="mt-2"/>

                            <jet-label for="performance" value="Performance" class="mt-4"/>
                            <jet-input type="number" id="performance" class="mt-1 block w-full" v-model.number="form.performance" required/>
                            <jet-input-error :message="form.errors.performance" class="mt-2"/>

                            <jet-label for="persuasion" value="Persuasion" class="mt-4"/>
                            <jet-input type="number" id="persuasion" class="mt-1 block w-full" v-model.number="form.persuasion" required/>
                            <jet-input-error :message="form.errors.persuasion" class="mt-2"/>

                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t dark:border-gray-600 pt-2 mt-10">
                <div class="flex items-center">
                    <h3 class="text-2xl font-bold inline-block heading-color">Spells</h3>
                    <jet-secondary-button type="button" class="ml-5" @click.prevent="form.spellcaster = !form.spellcaster">
                        {{ form.spellcaster ? 'Disable' : 'Enable' }}
                    </jet-secondary-button>
                </div>
                <div v-if="form.spellcaster">
                    <div class="grid grid-cols-1 sm:grid-cols-2">
                        <div class="col-span-1 px-1">
                            <!-- spell_type -->
                            <jet-label for="spell_type" value="Type" class="mt-4"/>
                            <select-input id="spell_type" class="mt-1 w-full" v-model="form.spell_type" :options="[['points', 'Points (DMG variant)'], ['slots', 'Slots']]"/>
                            <jet-input-error :message="form.errors.spell_type" class="mt-2"/>
                        </div>
                        <div class="col-span-1 px-1">
                            <!-- spell_dc -->
                            <jet-label for="spell_dc" value="Spell DC" class="mt-4"/>
                            <jet-input type="number" id="spell_dc" class="mt-1 w-full" v-model.number="form.spell_dc"/>
                            <jet-input-error :message="form.errors.spell_dc" class="mt-2"/>
                        </div>
                        <div class="col-span-1 px-1">
                            <!-- spell_recover -->
                            <jet-label for="spell_recover" value="Recovery" class="mt-4"/>
                            <select-input id="spell_recover" class="mt-1 w-full" v-model="form.spell_recover" :options="[['short', 'Short Rest'], ['long', 'Long Rest']]"/>
                            <jet-input-error :message="form.errors.spell_recover" class="mt-2"/>
                        </div>
                        <div class="col-span-1 px-1">
                            <!-- spell_list_type -->
                            <jet-label for="spell_list_type" value="Spellcaster Type" class="mt-4"/>
                            <select-input id="spell_list_type" class="mt-1 w-full" v-model="form.spell_list_type" :options="[['known', 'Known (learn on level up)'], ['prepared', 'Prepared (spellbook or full spell list)']]"/>
                            <jet-input-error :message="form.errors.spell_list_type" class="mt-2"/>
                        </div>
                        <div class="col-span-1 px-1" v-if="form.spell_list_type == 'prepared'">
                            <!-- spell_prepare_count -->
                            <jet-label for="spell_prepare_count" value="Number of spells that can be prepared (include always prepared race/class/feat spells to total)" class="mt-4"/>
                            <jet-input type="number" id="spell_prepare_count" class="mt-1 w-full" v-model.number="form.spell_prepare_count"/>
                            <jet-input-error :message="form.errors.spell_prepare_count" class="mt-2"/>
                        </div>
                    </div>
                    <div class="border-t dark:border-gray-600 mt-10 pt-2" v-if="form.spell_type == 'points'">
                        <p class="text-xl heading-color">Spell Points</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2">
                            <div class="col-span-1 px-1">
                                <!-- spell_level -->
                                <jet-label for="spell_level" value="Max Spell Level" class="mt-4"/>
                                <jet-input type="number" id="spell_level" class="mt-1 w-full" v-model.number="form.spell_level"/>
                                <jet-input-error :message="form.errors.spell_level" class="mt-2"/>
                            </div>
                            <div class="col-span-1 px-1">
                                <!-- spell_points_max -->
                                <jet-label for="spell_points_max" value="Total Spell Points" class="mt-4"/>
                                <jet-input type="number" id="spell_points_max" class="mt-1 w-full" v-model.number="form.spell_points_max"/>
                                <jet-input-error :message="form.errors.spell_points_max" class="mt-2"/>
                            </div>
                        </div>
                    </div>
                    <div class="border-t dark:border-gray-600 mt-10 pt-2" v-if="form.spell_type == 'slots'">
                        <p class="text-xl heading-color">Spell Slots</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3">
                            <!-- spell_slots -->
                            <div class="col-span-1 px-1" v-for="num in 9">
                                <jet-label :for="'spell_slots_int_' + num" :value="ordinalSuffix(num) + ' Level'" class="mt-4"/>
                                <jet-input type="number" :id="'spell_slots_int_' + num" class="mt-1 w-full" placeholder="0" v-model.number="form['spell_slots_int_' + num]"/>
                                <jet-input-error :message="form.errors['spell_slots' + num]" class="mt-2"/>
                            </div>
                        </div>
                    </div>
                    <div class="border-t dark:border-gray-600 mt-10 pt-2">
                        <p class="text-xl heading-color">Spell List</p>
                        <p class="my-2">{{spellListExplanation}}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2">
                            <!-- spell_list -->
                            <div class="col-span-1 px-1" v-for="(num, index) in 10">
                                <jet-label :for="'spell_list_string_' + index" :value="index == 0 ? 'Cantrips' : ordinalSuffix(index) + ' Level'" class="mt-4"/>
                                <textarea :id="'spell_list_string_' + index" class="w-full form-input" v-model="form['spell_list_string_' + index]"></textarea>
                                <jet-input-error :message="form.errors['spell_list_' + index]" class="mt-2"/>
                            </div>
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

    export default {
        props: ['creature', 'type'],
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
        data() {
            return {
                form: this.$inertia.form({
                    id: null,
                    name: null,
                    speed: '',
                    hp_max: 0,
                    hp_current: 0,
                    hit_dice: [{
                        count: 0,
                        size: 0,
                        current: 0,
                    }],
                    ac: 0,
                    ac_source: '',
                    initiative: 0,
                    strength: 0,
                    strength_save: 0,
                    strength_mod: 0,
                    strength_save_proficiency: false,
                    athletics: 0,
                    athletics_proficiency: false,
                    athletics_expertise: false,
                    dexterity: 0,
                    dexterity_save: 0,
                    dexterity_mod: 0,
                    dexterity_save_proficiency: false,
                    acrobatics: 0,
                    acrobatics_proficiency: false,
                    acrobatics_expertise: false,
                    sleight_of_hand: 0,
                    sleight_of_hand_proficiency: false,
                    sleight_of_hand_expertise: false,
                    stealth: 0,
                    stealth_proficiency: false,
                    stealth_expertise: false,
                    constitution: 0,
                    constitution_save: 0,
                    constitution_mod: 0,
                    constitution_save_proficiency: false,
                    intelligence: 0,
                    intelligence_save: 0,
                    intelligence_mod: 0,
                    intelligence_save_proficiency: false,
                    arcana: 0,
                    arcana_proficiency: false,
                    arcana_expertise: false,
                    history: 0,
                    history_proficiency: false,
                    history_expertise: false,
                    investigation: 0,
                    investigation_proficiency: false,
                    investigation_expertise: false,
                    nature: 0,
                    nature_proficiency: false,
                    nature_expertise: false,
                    religion: 0,
                    religion_proficiency: false,
                    religion_expertise: false,
                    wisdom: 0,
                    wisdom_save: 0,
                    wisdom_mod: 0,
                    wisdom_save_proficiency: false,
                    animal_handling: 0,
                    animal_handling_proficiency: false,
                    animal_handling_expertise: false,
                    insight: 0,
                    insight_proficiency: false,
                    insight_expertise: false,
                    medicine: 0,
                    medicine_proficiency: false,
                    medicine_expertise: false,
                    perception: 0,
                    perception_proficiency: false,
                    perception_expertise: false,
                    survival: 0,
                    survival_proficiency: false,
                    survival_expertise: false,
                    charisma: 0,
                    charisma_save: 0,
                    charisma_mod: 0,
                    charisma_save_proficiency: false,
                    deception: 0,
                    deception_proficiency: false,
                    deception_expertise: false,
                    intimidation: 0,
                    intimidation_proficiency: false,
                    intimidation_expertise: false,
                    performance: 0,
                    performance_proficiency: false,
                    performance_expertise: false,
                    persuasion: 0,
                    persuasion_proficiency: false,
                    persuasion_expertise: false,
                    skills_auto_filled: true,
                    special_skill_modifiers: [],
                    spellcaster: false,
                    spell_type: 'slots',
                    spell_dc: null,
                    spell_level: null,
                    spell_points_max: null,
                    spell_points_current: null,
                    spell_recover: 'long',
                    spell_list_type: 'known',
                    spell_slots_1: [],
                    spell_slots_2: [],
                    spell_slots_3: [],
                    spell_slots_4: [],
                    spell_slots_5: [],
                    spell_slots_6: [],
                    spell_slots_7: [],
                    spell_slots_8: [],
                    spell_slots_9: [],
                    spell_list_0: [],
                    spell_list_1: [],
                    spell_list_2: [],
                    spell_list_3: [],
                    spell_list_4: [],
                    spell_list_5: [],
                    spell_list_6: [],
                    spell_list_7: [],
                    spell_list_8: [],
                    spell_list_9: [],
                    spell_prepare_count: null,
                    spell_prepared: null,
                    damage_vulnerabilities: null,
                    damage_resistances: null,
                    damage_immunities: null,
                    condition_immunities: null,
                    languages: null,
                    senses: null,

                    // character fields
                    race: null,
                    class: null,
                    level: 0,

                    //monster fields
                    size: null,
                    type: null,
                    alignment: null,
                    challenge_rating: null,
                    experience: null,
                    source: null,
                    public: null,
                }),
            }
        },
        created() {
            if(this.creature) {
                this.form = this.$inertia.form({
                    id: this.creature.id,
                    name: this.creature.name,
                    speed: this.creature.speed,
                    hp_max: this.creature.hp_max,
                    hp_current: this.creature.hp_current,
                    hit_dice: this.creature.hit_dice,
                    ac: this.creature.ac,
                    ac_source: this.creature.ac_source,
                    initiative: this.creature.initiative,
                    strength: this.creature.strength,
                    strength_save: this.creature.strength_save,
                    strength_mod: this.creature.strength_mod,
                    strength_save_proficiency: this.creature.strength_save_proficiency,
                    athletics: this.creature.athletics,
                    athletics_proficiency: this.creature.athletics_proficiency,
                    athletics_expertise: this.creature.athletics_expertise,
                    dexterity: this.creature.dexterity,
                    dexterity_save: this.creature.dexterity_save,
                    dexterity_mod: this.creature.dexterity_mod,
                    dexterity_save_proficiency: this.creature.dexterity_save_proficiency,
                    acrobatics: this.creature.acrobatics,
                    acrobatics_proficiency: this.creature.acrobatics_proficiency,
                    acrobatics_expertise: this.creature.acrobatics_expertise,
                    sleight_of_hand: this.creature.sleight_of_hand,
                    sleight_of_hand_proficiency: this.creature.sleight_of_hand_proficiency,
                    sleight_of_hand_expertise: this.creature.sleight_of_hand_expertise,
                    stealth: this.creature.stealth,
                    stealth_proficiency: this.creature.stealth_proficiency,
                    stealth_expertise: this.creature.stealth_expertise,
                    constitution: this.creature.constitution,
                    constitution_save: this.creature.constitution_save,
                    constitution_mod: this.creature.constitution_mod,
                    constitution_save_proficiency: this.creature.constitution_save_proficiency,
                    intelligence: this.creature.intelligence,
                    intelligence_save: this.creature.intelligence_save,
                    intelligence_mod: this.creature.intelligence_mod,
                    intelligence_save_proficiency: this.creature.intelligence_save_proficiency,
                    arcana: this.creature.arcana,
                    arcana_proficiency: this.creature.arcana_proficiency,
                    arcana_expertise: this.creature.arcana_expertise,
                    history: this.creature.history,
                    history_proficiency: this.creature.history_proficiency,
                    history_expertise: this.creature.history_expertise,
                    investigation: this.creature.investigation,
                    investigation_proficiency: this.creature.investigation_proficiency,
                    investigation_expertise: this.creature.investigation_expertise,
                    nature: this.creature.nature,
                    nature_proficiency: this.creature.nature_proficiency,
                    nature_expertise: this.creature.nature_expertise,
                    religion: this.creature.religion,
                    religion_proficiency: this.creature.religion_proficiency,
                    religion_expertise: this.creature.religion_expertise,
                    wisdom: this.creature.wisdom,
                    wisdom_save: this.creature.wisdom_save,
                    wisdom_mod: this.creature.wisdom_mod,
                    wisdom_save_proficiency: this.creature.wisdom_save_proficiency,
                    animal_handling: this.creature.animal_handling,
                    animal_handling_proficiency: this.creature.animal_handling_proficiency,
                    animal_handling_expertise: this.creature.animal_handling_expertise,
                    insight: this.creature.insight,
                    insight_proficiency: this.creature.insight_proficiency,
                    insight_expertise: this.creature.insight_expertise,
                    medicine: this.creature.medicine,
                    medicine_proficiency: this.creature.medicine_proficiency,
                    medicine_expertise: this.creature.medicine_expertise,
                    perception: this.creature.perception,
                    perception_proficiency: this.creature.perception_proficiency,
                    perception_expertise: this.creature.perception_expertise,
                    survival: this.creature.survival,
                    survival_proficiency: this.creature.survival_proficiency,
                    survival_expertise: this.creature.survival_expertise,
                    charisma: this.creature.charisma,
                    charisma_save: this.creature.charisma_save,
                    charisma_mod: this.creature.charisma_mod,
                    charisma_save_proficiency: this.creature.charisma_save_proficiency,
                    deception: this.creature.deception,
                    deception_proficiency: this.creature.deception_proficiency,
                    deception_expertise: this.creature.deception_expertise,
                    intimidation: this.creature.intimidation,
                    intimidation_proficiency: this.creature.intimidation_proficiency,
                    intimidation_expertise: this.creature.intimidation_expertise,
                    performance: this.creature.performance,
                    performance_proficiency: this.creature.performance_proficiency,
                    performance_expertise: this.creature.performance_expertise,
                    persuasion: this.creature.persuasion,
                    persuasion_proficiency: this.creature.persuasion_proficiency,
                    persuasion_expertise: this.creature.persuasion_expertise,
                    skills_auto_filled: this.creature.skills_auto_filled,
                    special_skill_modifiers: this.creature.special_skill_modifiers,
                    spellcaster: this.creature.spellcaster,
                    spell_type: this.creature.spell_type,
                    spell_dc: this.creature.spell_dc,
                    spell_level: this.creature.spell_level,
                    spell_points_max: this.creature.spell_points_max,
                    spell_points_current: this.creature.spell_points_current,
                    spell_recover: this.creature.spell_recover,
                    spell_list_type: this.creature.spell_list_type,
                    spell_slots_1: this.creature.spell_slots_1,
                    spell_slots_2: this.creature.spell_slots_2,
                    spell_slots_3: this.creature.spell_slots_3,
                    spell_slots_4: this.creature.spell_slots_4,
                    spell_slots_5: this.creature.spell_slots_5,
                    spell_slots_6: this.creature.spell_slots_6,
                    spell_slots_7: this.creature.spell_slots_7,
                    spell_slots_8: this.creature.spell_slots_8,
                    spell_slots_9: this.creature.spell_slots_9,
                    spell_slots_int_1: this.getSlotCount(this.creature.spell_slots_1),
                    spell_slots_int_2: this.getSlotCount(this.creature.spell_slots_2),
                    spell_slots_int_3: this.getSlotCount(this.creature.spell_slots_3),
                    spell_slots_int_4: this.getSlotCount(this.creature.spell_slots_4),
                    spell_slots_int_5: this.getSlotCount(this.creature.spell_slots_5),
                    spell_slots_int_6: this.getSlotCount(this.creature.spell_slots_6),
                    spell_slots_int_7: this.getSlotCount(this.creature.spell_slots_7),
                    spell_slots_int_8: this.getSlotCount(this.creature.spell_slots_8),
                    spell_slots_int_9: this.getSlotCount(this.creature.spell_slots_9),
                    spell_list_0: this.creature.spell_list_0,
                    spell_list_1: this.creature.spell_list_1,
                    spell_list_2: this.creature.spell_list_2,
                    spell_list_3: this.creature.spell_list_3,
                    spell_list_4: this.creature.spell_list_4,
                    spell_list_5: this.creature.spell_list_5,
                    spell_list_6: this.creature.spell_list_6,
                    spell_list_7: this.creature.spell_list_7,
                    spell_list_8: this.creature.spell_list_8,
                    spell_list_9: this.creature.spell_list_9,
                    spell_list_string_0: this.joinList(this.creature.spell_list_0),
                    spell_list_string_1: this.joinList(this.creature.spell_list_1),
                    spell_list_string_2: this.joinList(this.creature.spell_list_2),
                    spell_list_string_3: this.joinList(this.creature.spell_list_3),
                    spell_list_string_4: this.joinList(this.creature.spell_list_4),
                    spell_list_string_5: this.joinList(this.creature.spell_list_5),
                    spell_list_string_6: this.joinList(this.creature.spell_list_6),
                    spell_list_string_7: this.joinList(this.creature.spell_list_7),
                    spell_list_string_8: this.joinList(this.creature.spell_list_8),
                    spell_list_string_9: this.joinList(this.creature.spell_list_9),
                    spell_prepare_count: this.creature.spell_prepare_count,
                    spell_prepared: this.creature.spell_prepared,
                    damage_vulnerabilities: this.creature.damage_vulnerabilities,
                    damage_resistances: this.creature.damage_resistances,
                    damage_immunities: this.creature.damage_immunities,
                    condition_immunities: this.creature.condition_immunities,
                    languages: this.creature.languages,
                    senses: this.creature.senses,

                    // character fields
                    race: this.creature.race,
                    class: this.creature.class,
                    level: this.creature.level,

                    // monster fields
                    size: this.creature.size,
                    type: this.creature.type,
                    alignment: this.creature.alignment,
                    challenge_rating: this.creature.challenge_rating,
                    experience: this.creature.experience,
                    source: this.creature.source,
                    public: this.creature.public,
                });

            }
        },
        computed: {
            skillsButtonText() {
                if (this.form.skills_auto_filled) {
                    return 'Swtich to Manual Skills';
                } else {
                    return 'Swtich to Automatic Skills';
                }
            },
            skillsText() {
                if (this.form.skills_auto_filled) {
                    return 'Skills are automatically calculated based on stats and proficencies.  If there are other factors affecting skills, click the button to switch to manual skills.';
                } else {
                    return 'Enter in all of the skill modifiers. Changing stats and proficiencies in the section above will not change the skill modifiers while in manual skills mode.';
                }
            },
            spellcasterButtonText() {
                if (this.form.spellcaster) {
                    return 'Disable';
                } else {
                    return 'Enable';
                }
            },
            spellListExplanation() {
                if(this.form.spell_list_type == 'known') {
                    return "List all of your known spells below.  Spells should be separated by a comma (ex: Firebolt, Minor Illusion).";
                } else {
                    return "List all of the spells in your spellbook or class's spell list below.  You will have the option later to select which spells from your list you have prepared and then only show the prepared spells.  Spells should be separated by a comma (ex: Firebolt, Minor Illusion).";
                }
            },
            proficiencyBonus() {
                let search = this.form.level ? this.form.level.toString() : this.form.challenge_rating;
                let result = 0;
                switch(search) {
                    case '':
                    case '0':
                    case '1/8':
                    case '1/4':
                    case '1/2':
                    case '1':
                    case '2':
                    case '3':
                    case '4':
                        result = 2;
                        break;
                    case '5':
                    case '6':
                    case '7':
                    case '8':
                        result = 3;
                        break;
                    case '9':
                    case '10':
                    case '11':
                    case '12':
                        result = 4;
                        break;
                    case '13':
                    case '14':
                    case '15':
                    case '16':
                        result = 5;
                        break;
                    case '17':
                    case '18':
                    case '19':
                    case '20':
                        result = 6;
                        break;
                    case '21':
                    case '22':
                    case '23':
                    case '24':
                        result = 7;
                        break;
                    case '25':
                    case '26':
                    case '27':
                    case '28':
                        result = 8;
                        break;
                    case '29':
                    case '30':
                        result = 9;
                        break;
                    default:
                        result = 0;
                        break;
                }
                return result;
            },
            baseStrengthMod() {
                return this.getStatModifier(this.form.strength);
            },
            baseDexterityMod() {
                return this.getStatModifier(this.form.dexterity);
            },
            baseConstitutionMod() {
                return this.getStatModifier(this.form.constitution);
            },
            baseIntelligenceMod() {
                return this.getStatModifier(this.form.intelligence);
            },
            baseWisdomMod() {
                return this.getStatModifier(this.form.wisdom);
            },
            baseCharismaMod() {
                return this.getStatModifier(this.form.charisma);
            },
        },
        methods: {
            ordinalSuffix(num) {
                let j = num % 10
                let k = num % 100;
                if (j == 1 && k != 11) {
                    return num + "st";
                }
                if (j == 2 && k != 12) {
                    return num + "nd";
                }
                if (j == 3 && k != 13) {
                    return num + "rd";
                }
                return num + "th";
            },
            getStatModifier(stat) {
                let result = -99;
                switch(stat) {
                    case 1:
                        result = -5;
                        break;
                    case 2:
                    case 3:
                        result = -4;
                        break;
                    case 4:
                    case 5:
                        result = -3;
                        break;
                    case 6:
                    case 7:
                        result = -2;
                        break;
                    case 8:
                    case 9:
                        result = -1;
                        break;
                    case 10:
                    case 11:
                        result = 0;
                        break;
                    case 12:
                    case 13:
                        result = 1;
                        break;
                    case 14:
                    case 15:
                        result = 2;
                        break;
                    case 16:
                    case 17:
                        result = 3;
                        break;
                    case 18:
                    case 19:
                        result = 4;
                        break;
                    case 20:
                    case 21:
                        result = 5;
                        break;
                    case 22:
                    case 23:
                        result = 6;
                        break;
                    case 24:
                    case 25:
                        result = 7;
                        break;
                    case 26:
                    case 27:
                        result = 8;
                        break;
                    case 28:
                    case 29:
                        result = 9;
                        break;
                    case 30:
                        result = 10;
                        break;
                }
                return result;
            },
            setSkills(stat = 'all') {
                if(this.form.skills_auto_filled) {
                    if(stat == 'strength' || stat == 'all') {
                        this.setSkill('strength_mod', this.baseStrengthMod);
                        this.setSkill('strength_save', this.baseStrengthMod);
                        this.setSkill('athletics', this.baseStrengthMod);
                    }
                    if(stat == 'dexterity' || stat == 'all') {
                        this.setSkill('dexterity_mod', this.baseDexterityMod);
                        this.setSkill('dexterity_save', this.baseDexterityMod);
                        this.setSkill('acrobatics', this.baseDexterityMod);
                        this.setSkill('sleight_of_hand', this.baseDexterityMod);
                        this.setSkill('stealth', this.baseDexterityMod);
                    }
                    if(stat == 'constitution' || stat == 'all') {
                        this.setSkill('constitution_mod', this.baseConstitutionMod);
                        this.setSkill('constitution_save', this.baseConstitutionMod);
                    }
                    if(stat == 'intelligence' || stat == 'all') {
                        this.setSkill('intelligence_mod', this.baseIntelligenceMod);
                        this.setSkill('intelligence_save', this.baseIntelligenceMod);
                        this.setSkill('arcana', this.baseIntelligenceMod);
                        this.setSkill('history', this.baseIntelligenceMod);
                        this.setSkill('investigation', this.baseIntelligenceMod);
                        this.setSkill('nature', this.baseIntelligenceMod);
                        this.setSkill('religion', this.baseIntelligenceMod);
                    }
                    if(stat == 'wisdom' || stat == 'all') {
                        this.setSkill('wisdom_mod', this.baseWisdomMod);
                        this.setSkill('wisdom_save', this.baseWisdomMod);
                        this.setSkill('animal_handling', this.baseWisdomMod);
                        this.setSkill('insight', this.baseWisdomMod);
                        this.setSkill('medicine', this.baseWisdomMod);
                        this.setSkill('perception', this.baseWisdomMod);
                        this.setSkill('survival', this.baseWisdomMod);
                    }
                    if(stat == 'charisma' || stat == 'all') {
                        this.setSkill('charisma_mod', this.baseCharismaMod);
                        this.setSkill('charisma_save', this.baseCharismaMod);
                        this.setSkill('deception', this.baseCharismaMod);
                        this.setSkill('intimidation', this.baseCharismaMod);
                        this.setSkill('performance', this.baseCharismaMod);
                        this.setSkill('persuasion', this.baseCharismaMod);
                    }

                    // if(this.special_skill_modifiers.includes('cloakOfProtection')) {
                    //     this.strength_save = this.strength_save + 1;
                    //     this.dexterity_save = this.dexterity_save + 1;
                    //     this.constitution_save = this.constitution_save + 1;
                    //     this.intelligence_save = this.intelligence_save + 1;
                    //     this.wisdom_save = this.wisdom_save + 1;
                    //     this.charisma_save = this.charisma_save + 1;
                    // }
                    // if(this.special_skill_modifiers.includes('ringOfProtection')) {
                    //     this.strength_save = this.strength_save + 1;
                    //     this.dexterity_save = this.dexterity_save + 1;
                    //     this.constitution_save = this.constitution_save + 1;
                    //     this.intelligence_save = this.intelligence_save + 1;
                    //     this.wisdom_save = this.wisdom_save + 1;
                    //     this.charisma_save = this.charisma_save + 1;
                    // }

                }
            },
            setSkill(skill, stat_modifier) {
                this.form[skill] = stat_modifier;
                if(this.form[skill+'_proficiency']) {
                    this.form[skill] += ((this.form[skill+'_expertise'] ? 2 : 1) * this.proficiencyBonus);
                }
            },
            toggleAutoSkills() {
                this.form.skills_auto_filled = !this.form.skills_auto_filled;
                if(this.form.skills_auto_filled) {
                    this.setSkills();
                }
            },
            joinList(list) {
                if(list != null) {
                    return list.join(', ');
                } else {
                    return '';
                }
            },
            splitList(list) {
                if(list && list != '') {
                    return list.split(', ').sort();
                } else {
                    return null;
                }
            },
            getSlotCount(slots) {
                if(slots && Array.isArray(slots)) {
                    return slots.length;
                }
                return null;
            },
            getSlotArray(level, count) {
                let output = [];
                if(this.spells && this.spells['slots_' + level] && Array.isArray(this.spells['slots_' + level])) {
                    output = this.spells['slots_' + level];
                }
                if(count > output.length) {
                    for(let j=output.length; j < count; j++) {
                        output.push(false);
                    }
                } else if(count < output.length) {
                    for(let j=output.length;j>count;j--) {
                        output.pop();
                    }
                }
                return output;
            },
            prepareSpellData() {
                for(let i=0;i<10;i++) {
                    this.form['spell_list_' + i] = this.splitList(this.form['spell_list_string_' + i]);
                    if(i != 0) {
                        this.form['spell_slots_' + i] = this.getSlotArray(i, this.form['spell_slots_int_' + i]);
                    }
                }
                if(this.form.spell_list_type == 'known') {
                    this.form.spell_prepare_count = null;
                    this.form.spell_prepared = null;
                }

                if (this.form.spell_type == 'points') {
                    this.form.spell_points_current = this.form.spell_points_max;
                    this.form.spell_slots_1 = [];
                    this.form.spell_slots_2 = [];
                    this.form.spell_slots_3 = [];
                    this.form.spell_slots_4 = [];
                    this.form.spell_slots_5 = [];
                    this.form.spell_slots_6 = [];
                    this.form.spell_slots_7 = [];
                    this.form.spell_slots_8 = [];
                    this.form.spell_slots_9 = [];
                } else if(this.form.spell_type == 'slots') {
                    this.form.spell_points_current = null;
                    this.form.spell_points_max = null;
                    this.form.spell_level = null;
                }
            },
            submit() {
                this.prepareSpellData();
                if(this.creature) {
                    this.form.patch(route(this.type.toLowerCase() + 's.update', this.form.id));
                } else {
                    this.form.post(route(this.type.toLowerCase() + 's.store'));
                }
            },
        },
    }
</script>
