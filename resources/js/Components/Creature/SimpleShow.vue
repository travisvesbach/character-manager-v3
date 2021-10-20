<template>
    <div class="rounded-md m-2 overflow-hidden flex flex-col" :class="hpColor">
        <simple-heading :creature="creature" :type="type"/>

        <div class="bg-gray-100 dark:bg-gray-900 p-1 flex-grow flex flex-col">
            <simple-stats :creature="creature" :type="type"/>

            <simple-modifiers :creature="creature" :type="type" v-if="creature.modifiers.length > 0"/>

            <simple-actions :creature="creature" :type="type" v-if="creature.actions.length > 0"/>

            <simple-spells :creature="creature" :type="type" v-if="creature.spellcaster"/>

            <simple-resources :creature="creature" :type="type" v-if="creature.resources.length > 0"/>

            <simple-notepad class="flex-grow" :creature="creature" :type="type"/>


        </div>
    </div>
</template>

<script>
    import SimpleHeading from '@/Components/Creature/SimpleHeading'
    import SimpleStats from '@/Components/Creature/SimpleStats'
    import SimpleSpells from '@/Components/Creature/SimpleSpells'
    import SimpleResources from '@/Components/Creature/SimpleResources'
    import SimpleModifiers from '@/Components/Creature/SimpleModifiers'
    import SimpleActions from '@/Components/Creature/SimpleActions'
    import SimpleNotepad from '@/Components/Creature/SimpleNotepad'

    import { CreatureBase } from '@/Mixins/Creature/Base';

    export default {
        components: {
            SimpleHeading,
            SimpleStats,
            SimpleSpells,
            SimpleResources,
            SimpleModifiers,
            SimpleActions,
            SimpleNotepad,
        },
        mixins: [CreatureBase],
        computed: {
            hpColor() {
                if(this.creature.hp_current <= 0) {
                    return 'bg-red-200 border border-red-200 dark:bg-red-900 dark:border-red-900';
                } else if(this.creature.hp_current <= this.creature.hp_max/2) {
                    return 'bg-yellow-200 border border-yellow-200 dark:bg-yellow-900 dark:border-yellow-900';
                } else {
                    return 'bg-green-200 border border-green-200 dark:bg-green-900 dark:border-green-900';
                }
            },
        },
        methods: {
        }
    }
</script>
