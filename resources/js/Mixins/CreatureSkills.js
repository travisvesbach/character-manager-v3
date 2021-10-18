export const CreatureSkills = {
    data() {
        return {
            skills: [
                {
                    slug: 'athletics',
                    name: 'Athletics',
                    stat: 'strength',
                }, {
                    slug: 'acrobatics',
                    name: 'Acrobatics',
                    stat: 'dexterity',
                }, {
                    slug: 'sleight_of_hand',
                    name: 'Sleight of Hand',
                    stat: 'dexterity',
                }, {
                    slug: 'stealth',
                    name: 'Stealth',
                    stat: 'dexterity',
                }, {
                    slug: 'arcana',
                    name: 'Arcana',
                    stat: 'intelligence',
                }, {
                    slug: 'history',
                    name: 'History',
                    stat: 'intelligence',
                }, {
                    slug: 'investigation',
                    name: 'Investigation',
                    stat: 'intelligence',
                }, {
                    slug: 'nature',
                    name: 'Nature',
                    stat: 'intelligence',
                }, {
                    slug: 'religion',
                    name: 'Religion',
                    stat: 'intelligence',
                }, {
                    slug: 'animal_handling',
                    name: 'Animal Handling',
                    stat: 'wisdom',
                }, {
                    slug: 'insight',
                    name: 'Insight',
                    stat: 'wisdom',
                }, {
                    slug: 'medicine',
                    name: 'Medicine',
                    stat: 'wisdom',
                }, {
                    slug: 'perception',
                    name: 'Perception',
                    stat: 'wisdom',
                }, {
                    slug: 'survival',
                    name: 'Survival',
                    stat: 'wisdom',
                }, {
                    slug: 'deception',
                    name: 'Deception',
                    stat: 'charisma',
                }, {
                    slug: 'intimidation',
                    name: 'Intimidation',
                    stat: 'charisma',
                }, {
                    slug: 'performance',
                    name: 'Performance',
                    stat: 'charisma',
                }, {
                    slug: 'persuasion',
                    name: 'Persuasion',
                    stat: 'charisma',
                },
            ],
        }
    },
    computed: {
        proficientSkills() {
            let skills = [];
            this.skills.forEach(function(skill, index) {
                console.log(skill);
                if(this.creature[skill.slug + '_proficiency'] || this.creature[skill.slug + '_expertise']) {
                    skills.push(skill);
                }
            }, this);
            return skills.sort((a, b) => (a.name > b.name) ? 1 : -1);
        },
    },
    methods: {
        skillsByStat(stat) {
            let result = this.skills;
            result = result.filter(function(skill) {
                if(skill.stat == stat) {
                    return true;
                } else {
                    return false;
                }
            });
            return result;
        }
    }
}
