export const CreatureSpells = {
    data() {
        return {
            accordion_key: 0,
            spell_point_costs: [2,3,5,6,7,9,10,11,13],
        };
    },
    computed: {
        filteredSpellLists() {
            let list = [];
            if(this.creature.spellcaster) {
                for(let i=0;i<10;i++) {
                    let level_list = this.creature['spell_list_' + i];
                    if(level_list && level_list.length > 0) {
                        if(this.creature.spell_list_type == 'known' || i == 0) {
                            list.push([i, level_list]);
                        } else if(this.creature.spell_prepared) {
                            let common = level_list.filter(value => this.creature.spell_prepared.includes(value));
                            if(common.length > 0) {
                                list.push([i, common]);
                            }
                        }
                    }
                }
                this.accordion_key++;
            }
            return list;
        },
        spell_point_costs_available() {
            return this.spell_point_costs.slice(0, this.creature.spell_level);
        }
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
        updateSlot(level, index) {
            this.creature['spell_slots_' + level][index] = !this.creature['spell_slots_' + level][index];
            this.updateCreature(true);
        },
        usePoints(cost = null) {
            if (this.creature.spell_points_current >= cost) {
                this.creature.spell_points_current -= cost;
            } else if(cost != null) {
                this.flash('Not enough spell points remaining', 'danger');
            }
            this.updateCreature(true);
        },
    },
}
