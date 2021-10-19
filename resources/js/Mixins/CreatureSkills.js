export const CreatureSkills = {
    data() {
        return {
            stats: [
                'strength',
                'dexterity',
                'constitution',
                'intelligence',
                'wisdom',
                'charisma'
            ],
            skills: [
                {
                    slug: 'strength_save',
                    name: 'Strength Save',
                    stat: 'strength',
                    type: 'save',
                }, {
                    slug: 'athletics',
                    name: 'Athletics',
                    stat: 'strength',
                    type: 'ability',
                }, {
                    slug: 'dexterity_save',
                    name: 'Dexterity Save',
                    stat: 'dexterity',
                    type: 'save',
                }, {
                    slug: 'acrobatics',
                    name: 'Acrobatics',
                    stat: 'dexterity',
                    type: 'ability',
                }, {
                    slug: 'sleight_of_hand',
                    name: 'Sleight of Hand',
                    stat: 'dexterity',
                    type: 'ability',
                }, {
                    slug: 'stealth',
                    name: 'Stealth',
                    stat: 'dexterity',
                    type: 'ability',
                }, {
                    slug: 'constitution_save',
                    name: 'Constitution Save',
                    stat: 'constitution',
                    type: 'save',
                }, {
                    slug: 'intelligence_save',
                    name: 'Intelligence Save',
                    stat: 'intelligence',
                    type: 'save',
                }, {
                    slug: 'arcana',
                    name: 'Arcana',
                    stat: 'intelligence',
                    type: 'ability',
                }, {
                    slug: 'history',
                    name: 'History',
                    stat: 'intelligence',
                    type: 'ability',
                }, {
                    slug: 'investigation',
                    name: 'Investigation',
                    stat: 'intelligence',
                    type: 'ability',
                }, {
                    slug: 'nature',
                    name: 'Nature',
                    stat: 'intelligence',
                    type: 'ability',
                }, {
                    slug: 'religion',
                    name: 'Religion',
                    stat: 'intelligence',
                    type: 'ability',
                }, {
                    slug: 'wisdom_save',
                    name: 'Wisdom Save',
                    stat: 'wisdom',
                    type: 'save',
                }, {
                    slug: 'animal_handling',
                    name: 'Animal Handling',
                    stat: 'wisdom',
                    type: 'ability',
                }, {
                    slug: 'insight',
                    name: 'Insight',
                    stat: 'wisdom',
                    type: 'ability',
                }, {
                    slug: 'medicine',
                    name: 'Medicine',
                    stat: 'wisdom',
                    type: 'ability',
                }, {
                    slug: 'perception',
                    name: 'Perception',
                    stat: 'wisdom',
                    type: 'ability',
                }, {
                    slug: 'survival',
                    name: 'Survival',
                    stat: 'wisdom',
                    type: 'ability',
                }, {
                    slug: 'charisma_save',
                    name: 'Charisma Save',
                    stat: 'charisma',
                    type: 'save',
                }, {
                    slug: 'deception',
                    name: 'Deception',
                    stat: 'charisma',
                    type: 'ability',
                }, {
                    slug: 'intimidation',
                    name: 'Intimidation',
                    stat: 'charisma',
                    type: 'ability',
                }, {
                    slug: 'performance',
                    name: 'Performance',
                    stat: 'charisma',
                    type: 'ability',
                }, {
                    slug: 'persuasion',
                    name: 'Persuasion',
                    stat: 'charisma',
                    type: 'ability',
                },
            ],
        }
    },
    methods: {
        skillsByStat(stat, type = null) {
            let result = this.skills;
            result = result.filter(function(skill) {
                if(skill.stat == stat) {
                    return true;
                } else {
                    return false;
                }
            });
            return result;
        },
        proficientSkills(type = null) {
            let skills = [];
            this.skills.forEach(function(skill, index) {
                if(this.creature[skill.slug + '_proficiency'] || this.creature[skill.slug + '_expertise']) {
                    if(!type || type == skill.type) {
                        skills.push(skill);
                    }
                }
            }, this);
            return skills.sort((a, b) => (a.name > b.name) ? 1 : -1);
        },
    },
}
