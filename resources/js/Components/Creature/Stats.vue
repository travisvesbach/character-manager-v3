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
    import JetDialogModal from '@/Jetstream/DialogModal'
    import GridSection from '@/Components/GridSection';

    import { CreatureStats } from '@/Mixins/Creature/Stats';

    export default {
        components: {
            JetDialogModal,
            GridSection,
        },
        mixins: [CreatureStats],
        methods: {
            rest() {
                let form = this.$inertia.form({
                    id: this.creature.id,
                    length: this.rest_length,
                });

                form.patch(this.getRoute('rest'), {
                    preserveState: true,
                    preserveScroll: true,
                });

                this.rest_length = null;
            },
            capitalize(input) {
                return input.replace(/(^\w|\s\w)(\S*)/g, (_,m1,m2) => m1.toUpperCase()+m2.toLowerCase());
            }
        }
    }
</script>
