import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import Accordion from '@/Components/Accordion'
import AccordionItem from '@/Components/AccordionItem'

import { Flash } from '@/Mixins/Flash';
import { CreatureBase } from '@/Mixins/Creature/Base';

export const CreatureActions = {
    components: {
        JetButton,
        JetSecondaryButton,
        Accordion,
        AccordionItem,
    },
    mixins: [Flash, CreatureBase],
    methods: {
        roll(action, advantage = null) {
            let critical = null;
            let output_array = [];
            output_array.push(this.creature.display_name + ':<br>' + action.name + (advantage ? ' with ' + advantage : '') + ':');

            // get attack roll(s)
            if(action.attack) {
                let attack_rolls = [];
                attack_rolls.push(dice.roll());
                if(advantage) {
                    attack_rolls.push(dice.roll());
                }
                let attack_total = attack_rolls[0];
                if(advantage == 'advantage') {
                    attack_total = Math.max(...attack_rolls);
                } else if(advantage == 'disadvantage') {
                    attack_total = Math.min(...attack_rolls);
                }

                // check if critical hit
                let crit_min = this.creature.modifiers.reduce((min, modifier) => modifier.enabled && modifier.critical_range ? modifier.critical_range_start < min ? modifier.critical_range_start : min : min, 20);
                critical = attack_total >= crit_min ? 'success' : attack_total == 1 ? 'fail' : false;

                if(action.attack_modifier) {
                    attack_total += action.attack_modifier;
                }
                let message = 'Attack roll: [' + attack_rolls.join(',') + ']' + (action.attack_modifier ? ' + ' + action.attack_modifier : '');

                // get attack modifiers
                let attack_modifiers = this.creature.modifiers.filter(value => value.enabled && value['attack']);

                for(const mod of attack_modifiers) {
                    for(const mod_dice of mod['attack_dice']) {
                        message += (mod_dice.count > 0 ? ' + [' : '');
                        for(let x=0;x<mod_dice.count;x++) {
                            let result = dice.roll(mod_dice.size);
                            message += (x > 0 ? ', ' : '') + result;
                            attack_total += result
                        }
                        message += mod_dice.count > 0 ? ']' : '';
                        if(mod_dice.modifier) {
                            message += (mod_dice.modifier ? ' + ' + mod_dice.modifier : '');
                            attack_total += mod_dice.modifier;
                        }
                        message += ' [' + mod.name + ']';
                    }
                }

                message += ' = ' + (attack_total);

                output_array.push(message);

                if(critical == 'success') {
                    output_array.push('Critical Hit!');
                }
                if(critical == 'fail') {
                    output_array.push('Critical Fail...');
                    this.flash(output_array.join('<br>'), 'danger');
                    return;
                }
            }

            let damage = {
                types: [],
                total: 0,
                saves: [],
                output_array: [],
            }

            // roll damage/save
            if(action.attack && action.attack_does_damage) {
                damage = this.rollDamage(damage, action.attack_dice, critical);
            }
            if(action.auto && action.auto_does_damage) {
                damage = this.rollDamage(damage, action.auto_dice);
            }
            if(action.save) {
                damage = this.rollSave(damage, action);
            }

            // roll active damage modifiers
            this.creature.modifiers.filter(value => value.enabled && value['damage']).forEach(function(modifier) {
                if(modifier.damage_as == 'attack' && action.attack && action.attack_does_damage ) {
                    damage = this.rollDamage(damage, modifier.damage_dice, critical, modifier.name);
                }
                if (modifier.damage_as == 'save') {
                    damage = this.rollSave(damage, {
                        name: modifier.name,
                        save_dc: modifier.damage_dc,
                        save_type: modifier.damage_save,
                        save_dice: modifier.damage_dice,
                        save_does_damage: true,
                    });
                }
            }, this);

            // add damage.types to ouput_array
            if(damage.types && damage.types.length > 0) {
                damage.types.forEach(function(type) {
                    output_array.push(type.output + ' = ' + type.total);
                });
                if(damage.types.length > 1) {
                    output_array.push('Total Attack Damage: ' + damage.total);
                }
            }
            // add damage.saves to ouput_array
            if(damage.saves && damage.saves.length > 0) {
                damage.saves.forEach(function(damage_save) {
                    output_array = output_array.concat(damage_save.output_array);
                });
            }

            // add notes to output
            let notes = [];
            if(action.notes && action.notes.length > 0) {
                notes.push(action.notes);
            }
            this.creature.modifiers.filter(value => value.enabled && value['attack']).forEach(function(modifier) {
                if(modifier.notes && modifier.notes.length > 0) {
                    notes.push(modifier.name + ': ' + modifier.notes);
                }
            });
            this.creature.modifiers.filter(value => value.enabled && value['damage']).forEach(function(modifier) {
                if(modifier.notes && modifier.notes.length > 0) {
                    notes.push(modifier.name + ': ' + modifier.notes);
                }
            });
            if(notes.length > 0) {
                output_array.push('-------------------------');
                output_array = output_array.concat(notes);
            }

            this.flash(output_array.join('<br>'), critical == 'success' ? 'success' : 'primary');
        },
        rollDamage(damage, dice_array, critical = null, name = null) {
            dice_array.forEach(function(dice_obj) {
                let damage_roll = null
                let total = dice_obj.modifier;
                let damage_rolls_array = [];
                if(dice_obj.count > 0) {
                    for(let i=0;i<(critical == 'success' ? 2 : 1);i++) {
                        for(let x=0;x<dice_obj.count;x++) {
                            damage_roll = dice.roll(dice_obj.size);
                            total = total + damage_roll;
                            damage_rolls_array.push(damage_roll);
                        }
                    }
                }
                let type_index = dice_obj.type == 'Same as attack' ? 0 : damage.types.findIndex(x => x.type == dice_obj.type);
                let new_index = false;
                if(type_index < 0) {
                    damage.types.push({
                        type: dice_obj.type,
                        total: 0,
                        output: dice_obj.type + ' Damage: ',
                    });
                    type_index = damage.types.findIndex(x => x.type == dice_obj.type);
                    new_index = true;
                }
                damage.types[type_index].total += total;
                damage.types[type_index].output += (!new_index ? ' + ' : '')
                    + (damage_rolls_array.length > 0 ? '[' + damage_rolls_array.join(', ') + ']' : '')
                    + (damage_rolls_array.length > 0 && dice_obj.modifier && dice_obj.modifier != 0 ? ' + ' : '')
                    + (dice_obj.modifier && dice_obj.modifier != 0 ? dice_obj.modifier : '')
                    + (name ? ' [' + name + ']' : '');
                damage.total += total;
            });
            return damage;
        },
        rollSave(damage, action) {
            let output_array = [];
            let total = 0;
            if(!damage.saves) {
                damage.saves = [];
            }
            output_array.push('Target(s) make a DC ' + action.save_dc + ' ' + action.save_type + ' saving throw.');
            if(action.save_does_damage) {
                action.save_dice.forEach(function(dice_obj) {
                    let damage_roll = null
                    let damage_rolls_array = [];
                    let damage_total = dice_obj.modifier;
                    for(let i=0;i<dice_obj.count;i++) {
                        damage_roll = dice.roll(dice_obj.size);
                        damage_total += damage_roll;
                        damage_rolls_array.push(damage_roll);
                    }
                    output_array.push(dice_obj.type + ' Damage: [' + damage_rolls_array + '] ' + (dice_obj.modifier ? '+ ' + dice_obj.modifier : '') + ' = ' + damage_total);
                    total += damage_total;
                }, action);
                if(action.save_dice.length > 1) {
                    output_array.push('Total Save Damage: ' + total);
                }
            }
            damage.saves.push({
                name: action.name,
                output_array: output_array,
            });
            return damage;
        },
    },
}
