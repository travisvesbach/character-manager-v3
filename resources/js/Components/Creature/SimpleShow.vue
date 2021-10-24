<template>
    <div class="flex flex-col">
        <div class="rounded-md m-2 overflow-hidden flex flex-col duration-300" :class="classes">
            <simple-heading :creature="creature" :type="type" @toggleShow="show = !show"/>

            <transition-expand>
                <div class="bg-gray-100 dark:bg-gray-900 p-1 flex-grow flex flex-col" v-if="show">
                    <simple-stats :creature="creature" :type="type"/>

                    <simple-modifiers :creature="creature" :type="type" v-if="creature.modifiers.length > 0"/>

                    <simple-actions :creature="creature" :type="type" v-if="creature.actions.length > 0"/>

                    <simple-spells :creature="creature" :type="type" v-if="creature.spellcaster"/>

                    <simple-resources :creature="creature" :type="type" v-if="creature.resources.length > 0"/>

                    <simple-notepad class="flex-grow" :creature="creature" :type="type"/>
                </div>
            </transition-expand>
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
    import TransitionExpand from '@/Components/TransitionExpand'

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
            TransitionExpand
        },
        mixins: [CreatureBase],
        data() {
            return {
                accordion_key: 0,
                show: false,
            }
        },
        computed: {
            classes() {
                let classes = '';
                if(this.creature.hp_current <= 0) {
                    classes += 'bg-red-200 border border-red-200 dark:bg-red-900 dark:border-red-900';
                } else if(this.creature.hp_current <= this.creature.hp_max/2) {
                    classes += 'bg-yellow-200 border border-yellow-200 dark:bg-yellow-900 dark:border-yellow-900';
                } else {
                    classes += 'bg-green-200 border border-green-200 dark:bg-green-900 dark:border-green-900';
                }
                if(this.show) {
                    classes += ' flex-grow';
                }
                return classes;
            },
        },
        methods: {
        }
    }
</script>

<style type="text/css">
    .height-min-content {
        height: min-content;
    }
</style>
