<template>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
        <grid-section v-for="stat in stats">
            <button class="block btn-text" @click="roll(capitalize(stat), creature[stat + '_mod'], 'ability')" :disabled="disabled">
                <strong>{{ capitalize(stat) }}: {{ creature[stat] }} ({{ displayStat(creature[stat + '_mod']) }})</strong>
            </button>
            <div v-for="skill in skillsByStat(stat)">
                <button class="block btn-text" :class="proficiencyClass(creature[skill.slug + '_proficiency'])" @click="roll(skill.name, creature[skill.slug], skill.type)" :disabled="disabled">
                    {{ skill.type == 'save' ? skill.name.substr(skill.name.indexOf(' ') + 1) : skill.name }}: {{ displayStat(creature[skill.slug]) }}
                </button>
            </div>

            <div class="border-t dark:border-gray-600 mt-6 pt-1" :class="disabled ? 'hidden' : ''" v-if="stat == 'constitution'">
                <p><strong>Rests</strong></p>
                <jet-secondary-button class="mr-2" size="xs" @click="rest_length = 'short'">
                    Short Rest
                </jet-secondary-button>
                <jet-secondary-button size="xs" @click="rest_length = 'long'">
                    Long Rest
                </jet-secondary-button>
            </div>
        </grid-section>

        <!-- action modal -->
        <jet-dialog-modal :show="rest_length" max-width="xl" @close="rest_length = null">
            <template #header>
                Confirm Rest
            </template>

            <template #content>
                Take a {{ rest_length }} rest?
            </template>

            <template #footerend>
                <jet-secondary-button @click="rest_length = null">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="rest">
                    Rest
                </jet-button>
            </template>
        </jet-dialog-modal>

    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import GridSection from '@/Components/GridSection';

    import { Flash } from '@/Mixins/Flash';
    import { CreatureBase } from '@/Mixins/Creature/Base';
    import { CreatureSkills } from '@/Mixins/Creature/Skills';

    export default {
        components: {
            JetButton,
            JetSecondaryButton,
            JetDialogModal,
            GridSection,
        },
        mixins: [Flash, CreatureBase, CreatureSkills],
        data() {
            return {
                rest_length: null,
            }
        },
        methods: {
            roll(item, modifier, type) {
                let modifiers = this.creature.modifiers.filter(value => value.enabled && value[type]);
                let total = dice.roll();
                let message = this.creature.display_name + ':<br>' + item + ': [' + total + ']' + (modifier ? ' + ' + modifier : '');

                total += modifier;
                for(const mod of modifiers) {
                    for(const mod_dice of mod[type + '_dice']) {
                        message += (mod_dice.count > 0 ? ' + [' : '');
                        for(let x=0;x<mod_dice.count;x++) {
                            let result = dice.roll(mod_dice.size);
                            message += (x > 0 ? ', ' : '') + result;
                            total += result;
                        }
                        message += mod_dice.count > 0 ? ']' : '';
                        if(mod_dice.modifier) {
                            message += (mod_dice.modifier ? ' + ' + mod_dice.modifier : '');
                            total += mod_dice.modifier;
                        }
                        message += ' [' + mod.name + ']';
                    }
                }
                message += ' = ' + (total);
                this.flash(message, 'primary');
            },
            displayStat(stat) {
                return (stat > 0 ? '+' : '') + stat;
            },
            proficiencyClass(proficient) {
                return proficient ? 'italic' : '';
            },
            rest() {
                let form = this.$inertia.form({
                    id: this.creature.id,
                    length: this.rest_length,
                });

                form.patch(this.getRoute('rest'), {
                    preserveState: true,
                    // preserveScroll: true,
                });

                this.rest_length = null;
            },
            capitalize(input) {
                return input.replace(/(^\w|\s\w)(\S*)/g, (_,m1,m2) => m1.toUpperCase()+m2.toLowerCase());
            }
        }
    }
</script>
