export const CreatureBase = {
    props: ['creature', 'type'],
    computed: {
        ownerOrAdmin() {
            if(this.$page.props.user.id == this.creature.user_id || this.$page.props.user.admin) {
                return true;
            }
            return false;
        },
        disabled() {
            if(this.type == 'Monster') {
                return true;
            }
            return false;
        }
    },
    methods: {
        getRoute(method) {
            let $attributes = [];
            if(this.creature) {
                if(this.type == 'Encounter Monster') {
                    $attributes.push(this.creature.encounter_id);
                }
                $attributes.push(this.creature.id);
            }

            return this.route(this.type.toLowerCase().replace(/ /g, "_") + 's.' + method, $attributes);
        },
        getModel() {
            return this.type.replace(/ /g, "");
        },
        updateCreature(no_alert = false) {
            let form = this.$inertia.form({
                id:                             this.creature.id,
                name:                           this.creature.name,
                speed:                          this.creature.speed,
                hp_max:                         this.creature.hp_max,
                hp_current:                     this.creature.hp_current,
                hp_temp:                        this.creature.hp_temp,
                hit_dice:                       this.creature.hit_dice,
                ac:                             this.creature.ac,
                ac_source:                      this.creature.ac_source,
                initiative:                     this.creature.initiative,
                strength:                       this.creature.strength,
                strength_save:                  this.creature.strength_save,
                strength_mod:                   this.creature.strength_mod,
                strength_save_proficiency:      this.creature.strength_save_proficiency,
                athletics:                      this.creature.athletics,
                athletics_proficiency:          this.creature.athletics_proficiency,
                athletics_expertise:            this.creature.athletics_expertise,
                dexterity:                      this.creature.dexterity,
                dexterity_save:                 this.creature.dexterity_save,
                dexterity_mod:                  this.creature.dexterity_mod,
                dexterity_save_proficiency:     this.creature.dexterity_save_proficiency,
                acrobatics:                     this.creature.acrobatics,
                acrobatics_proficiency:         this.creature.acrobatics_proficiency,
                acrobatics_expertise:           this.creature.acrobatics_expertise,
                sleight_of_hand:                this.creature.sleight_of_hand,
                sleight_of_hand_proficiency:    this.creature.sleight_of_hand_proficiency,
                sleight_of_hand_expertise:      this.creature.sleight_of_hand_expertise,
                stealth:                        this.creature.stealth,
                stealth_proficiency:            this.creature.stealth_proficiency,
                stealth_expertise:              this.creature.stealth_expertise,
                constitution:                   this.creature.constitution,
                constitution_save:              this.creature.constitution_save,
                constitution_mod:               this.creature.constitution_mod,
                constitution_save_proficiency:  this.creature.constitution_save_proficiency,
                intelligence:                   this.creature.intelligence,
                intelligence_save:              this.creature.intelligence_save,
                intelligence_mod:               this.creature.intelligence_mod,
                intelligence_save_proficiency:  this.creature.intelligence_save_proficiency,
                arcana:                         this.creature.arcana,
                arcana_proficiency:             this.creature.arcana_proficiency,
                arcana_expertise:               this.creature.arcana_expertise,
                history:                        this.creature.history,
                history_proficiency:            this.creature.history_proficiency,
                history_expertise:              this.creature.history_expertise,
                investigation:                  this.creature.investigation,
                investigation_proficiency:      this.creature.investigation_proficiency,
                investigation_expertise:        this.creature.investigation_expertise,
                nature:                         this.creature.nature,
                nature_proficiency:             this.creature.nature_proficiency,
                nature_expertise:               this.creature.nature_expertise,
                religion:                       this.creature.religion,
                religion_proficiency:           this.creature.religion_proficiency,
                religion_expertise:             this.creature.religion_expertise,
                wisdom:                         this.creature.wisdom,
                wisdom_save:                    this.creature.wisdom_save,
                wisdom_mod:                     this.creature.wisdom_mod,
                wisdom_save_proficiency:        this.creature.wisdom_save_proficiency,
                animal_handling:                this.creature.animal_handling,
                animal_handling_proficiency:    this.creature.animal_handling_proficiency,
                animal_handling_expertise:      this.creature.animal_handling_expertise,
                insight:                        this.creature.insight,
                insight_proficiency:            this.creature.insight_proficiency,
                insight_expertise:              this.creature.insight_expertise,
                medicine:                       this.creature.medicine,
                medicine_proficiency:           this.creature.medicine_proficiency,
                medicine_expertise:             this.creature.medicine_expertise,
                perception:                     this.creature.perception,
                perception_proficiency:         this.creature.perception_proficiency,
                perception_expertise:           this.creature.perception_expertise,
                survival:                       this.creature.survival,
                survival_proficiency:           this.creature.survival_proficiency,
                survival_expertise:             this.creature.survival_expertise,
                charisma:                       this.creature.charisma,
                charisma_save:                  this.creature.charisma_save,
                charisma_mod:                   this.creature.charisma_mod,
                charisma_save_proficiency:      this.creature.charisma_save_proficiency,
                deception:                      this.creature.deception,
                deception_proficiency:          this.creature.deception_proficiency,
                deception_expertise:            this.creature.deception_expertise,
                intimidation:                   this.creature.intimidation,
                intimidation_proficiency:       this.creature.intimidation_proficiency,
                intimidation_expertise:         this.creature.intimidation_expertise,
                performance:                    this.creature.performance,
                performance_proficiency:        this.creature.performance_proficiency,
                performance_expertise:          this.creature.performance_expertise,
                persuasion:                     this.creature.persuasion,
                persuasion_proficiency:         this.creature.persuasion_proficiency,
                persuasion_expertise:           this.creature.persuasion_expertise,
                skills_auto_filled:             this.creature.skills_auto_filled,
                special_skill_modifiers:        this.creature.special_skill_modifiers,
                spellcaster:                    this.creature.spellcaster,
                spell_type:                     this.creature.spell_type,
                spell_dc:                       this.creature.spell_dc,
                spell_level:                    this.creature.spell_level,
                spell_points_max:               this.creature.spell_points_max,
                spell_points_current:           this.creature.spell_points_current,
                spell_recover:                  this.creature.spell_recover,
                spell_list_type:                this.creature.spell_list_type,
                spell_slots_1:                  this.creature.spell_slots_1,
                spell_slots_2:                  this.creature.spell_slots_2,
                spell_slots_3:                  this.creature.spell_slots_3,
                spell_slots_4:                  this.creature.spell_slots_4,
                spell_slots_5:                  this.creature.spell_slots_5,
                spell_slots_6:                  this.creature.spell_slots_6,
                spell_slots_7:                  this.creature.spell_slots_7,
                spell_slots_8:                  this.creature.spell_slots_8,
                spell_slots_9:                  this.creature.spell_slots_9,
                spell_list_0:                   this.creature.spell_list_0,
                spell_list_1:                   this.creature.spell_list_1,
                spell_list_2:                   this.creature.spell_list_2,
                spell_list_3:                   this.creature.spell_list_3,
                spell_list_4:                   this.creature.spell_list_4,
                spell_list_5:                   this.creature.spell_list_5,
                spell_list_6:                   this.creature.spell_list_6,
                spell_list_7:                   this.creature.spell_list_7,
                spell_list_8:                   this.creature.spell_list_8,
                spell_list_9:                   this.creature.spell_list_9,
                spell_prepare_count:            this.creature.spell_prepare_count,
                spell_prepared:                 this.creature.spell_prepared,
                notes:                          this.creature.notes,
                show_modifiers:                 this.creature.show_modifiers,
                show_resources:                 this.creature.show_resources,
                show_notes:                     this.creature.show_notes,
                show_dice:                      this.creature.show_dice,
                show_additional_stats:          this.creature.show_additional_stats,
                show_temp_hp:                  this.creature.show_temp_hp,
                damage_vulnerabilities:         this.creature.damage_vulnerabilities,
                damage_resistances:             this.creature.damage_resistances,
                damage_immunities:              this.creature.damage_immunities,
                condition_immunities:           this.creature.condition_immunities,
                languages:                      this.creature.languages,
                senses:                         this.creature.senses,
                no_alert:                       no_alert ?? false,


                // character fields
                race:               this.type == 'Character' ? this.creature.race : null,
                class:              this.type == 'Character' ? this.creature.class : null,
                level:              this.type == 'Character' ? this.creature.level : null,

                // monster fields
                public:             this.type == 'Monster' ? this.creature.public : null,

                // monster and encounter monster fields
                size:               this.type == 'Monster' || this.type == 'Encounter Monster' ? this.creature.size : null,
                type:               this.type == 'Monster' || this.type == 'Encounter Monster' ? this.creature.type : null,
                alignment:          this.type == 'Monster' || this.type == 'Encounter Monster' ? this.creature.alignment : null,
                challenge_rating:   this.type == 'Monster' || this.type == 'Encounter Monster' ? this.creature.challenge_rating : null,
                experience:         this.type == 'Monster' || this.type == 'Encounter Monster' ? this.creature.experience : null,
                source:             this.type == 'Monster' || this.type == 'Encounter Monster' ? this.creature.source : null,

                // encounter monster fields
                encounter_id:       this.type == 'Encounter Monster' ? this.creature.encounter_id: null,
                weight:             this.type == 'Encounter Monster' ? this.creature.weight: null,
                name_number:        this.type == 'Encounter Monster' ? this.creature.name_number: null,
            });

            form.patch(this.getRoute('update'), {
                preserveState: true,
                preserveScroll: true,
            });
        }
    }
}
