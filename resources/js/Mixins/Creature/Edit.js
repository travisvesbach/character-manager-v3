export const creatureEdit = {
    data() {
        return {
            form: this.$inertia.form({
                id: null,
                name: null,
                speed: '',
                max_hp: 0,
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
                // character fields
                race: null,
                class: null,
                level: 0,
            }),
        }
    },
    created() {
        if(this.editing) {
            this.form = this.$inertia.form({
                id: this.editing.id,
                name: this.editing.name,
                speed: this.editing.speed,
                max_hp: this.editing.max_hp,
                ac: this.editing.ac,
                ac_source: this.editing.ac_source,
                initiative: this.editing.initiative,
                strength: this.editing.strength,
                strength_save: this.editing.strength_save,
                strength_mod: this.editing.strength_mod,
                strength_save_proficiency: this.editing.strength_save_proficiency,
                athletics: this.editing.athletics,
                athletics_proficiency: this.editing.athletics_proficiency,
                athletics_expertise: this.editing.athletics_expertise,
                dexterity: this.editing.dexterity,
                dexterity_save: this.editing.dexterity_save,
                dexterity_mod: this.editing.dexterity_mod,
                dexterity_save_proficiency: this.editing.dexterity_save_proficiency,
                acrobatics: this.editing.acrobatics,
                acrobatics_proficiency: this.editing.acrobatics_proficiency,
                acrobatics_expertise: this.editing.acrobatics_expertise,
                sleight_of_hand: this.editing.sleight_of_hand,
                sleight_of_hand_proficiency: this.editing.sleight_of_hand_proficiency,
                sleight_of_hand_expertise: this.editing.sleight_of_hand_expertise,
                stealth: this.editing.stealth,
                stealth_proficiency: this.editing.stealth_proficiency,
                stealth_expertise: this.editing.stealth_expertise,
                constitution: this.editing.constitution,
                constitution_save: this.editing.constitution_save,
                constitution_mod: this.editing.constitution_mod,
                constitution_save_proficiency: this.editing.constitution_save_proficiency,
                intelligence: this.editing.intelligence,
                intelligence_save: this.editing.intelligence_save,
                intelligence_mod: this.editing.intelligence_mod,
                intelligence_save_proficiency: this.editing.intelligence_save_proficiency,
                arcana: this.editing.arcana,
                arcana_proficiency: this.editing.arcana_proficiency,
                arcana_expertise: this.editing.arcana_expertise,
                history: this.editing.history,
                history_proficiency: this.editing.history_proficiency,
                history_expertise: this.editing.history_expertise,
                investigation: this.editing.investigation,
                investigation_proficiency: this.editing.investigation_proficiency,
                investigation_expertise: this.editing.investigation_expertise,
                nature: this.editing.nature,
                nature_proficiency: this.editing.nature_proficiency,
                nature_expertise: this.editing.nature_expertise,
                religion: this.editing.religion,
                religion_proficiency: this.editing.religion_proficiency,
                religion_expertise: this.editing.religion_expertise,
                wisdom: this.editing.wisdom,
                wisdom_save: this.editing.wisdom_save,
                wisdom_mod: this.editing.wisdom_mod,
                wisdom_save_proficiency: this.editing.wisdom_save_proficiency,
                animal_handling: this.editing.animal_handling,
                animal_handling_proficiency: this.editing.animal_handling_proficiency,
                animal_handling_expertise: this.editing.animal_handling_expertise,
                insight: this.editing.insight,
                insight_proficiency: this.editing.insight_proficiency,
                insight_expertise: this.editing.insight_expertise,
                medicine: this.editing.medicine,
                medicine_proficiency: this.editing.medicine_proficiency,
                medicine_expertise: this.editing.medicine_expertise,
                perception: this.editing.perception,
                perception_proficiency: this.editing.perception_proficiency,
                perception_expertise: this.editing.perception_expertise,
                survival: this.editing.survival,
                survival_proficiency: this.editing.survival_proficiency,
                survival_expertise: this.editing.survival_expertise,
                charisma: this.editing.charisma,
                charisma_save: this.editing.charisma_save,
                charisma_mod: this.editing.charisma_mod,
                charisma_save_proficiency: this.editing.charisma_save_proficiency,
                deception: this.editing.deception,
                deception_proficiency: this.editing.deception_proficiency,
                deception_expertise: this.editing.deception_expertise,
                intimidation: this.editing.intimidation,
                intimidation_proficiency: this.editing.intimidation_proficiency,
                intimidation_expertise: this.editing.intimidation_expertise,
                performance: this.editing.performance,
                performance_proficiency: this.editing.performance_proficiency,
                performance_expertise: this.editing.performance_expertise,
                persuasion: this.editing.persuasion,
                persuasion_proficiency: this.editing.persuasion_proficiency,
                persuasion_expertise: this.editing.persuasion_expertise,
                skills_auto_filled: this.editing.skills_auto_filled,
                special_skill_modifiers: this.editing.special_skill_modifiers,
                // character fields
                race: this.editing.race,
                class: this.editing.class,
                level: this.editing.level,
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
        proficiencyBonus() {
            let search = this.form.level ? this.form.level.toString() : this.form.challenge;
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
                    result = 9;
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
        getStatModifier(stat) {
            console.log(stat);
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
                    console.log('here');
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
        statChange(stat = 'all') {
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
    }
}
