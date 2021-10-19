<template>
    <div class="rounded-md m-2 overflow-hidden flex flex-col" :class="hpColor">
        <simple-heading :creature="creature" :type="type"/>

        <div class="bg-gray-200 dark:bg-gray-900 p-1 flex-grow">
            <simple-stats :creature="creature" :type="type"/>

            <simple-actions :creature="creature" :type="type"/>

                <!-- <additional-stats :creature="creature" :type="type" v-if="creature.show_additional_stats"/>

                <actions class="flex-grow" :creature="creature" :type="type"/>

                <dice :creature="creature" :disabled="disabled" v-if="creature.show_dice"/> -->


        </div>
    </div>
</template>

<script>
    import SimpleHeading from '@/Components/Creature/SimpleHeading'
    import SimpleStats from '@/Components/Creature/SimpleStats'
    import Spells from '@/Components/Creature/Spells'
    import Resources from '@/Components/Creature/Resources'
    import Modifiers from '@/Components/Creature/Modifiers'
    import SimpleActions from '@/Components/Creature/SimpleActions'
    import Notepad from '@/Components/Creature/Notepad'
    import Dice from '@/Components/Dice'
    import AdditionalStats from '@/Components/Creature/AdditionalStats'

    import { CreatureBase } from '@/Mixins/Creature/Base';

    export default {
        components: {
            SimpleHeading,
            SimpleStats,
            Spells,
            Resources,
            Modifiers,
            SimpleActions,
            Notepad,
            Dice,
            AdditionalStats,
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
