<template>
    <div>
        <simple-heading :creature="creature" :type="type"/>

        <!-- <stats :creature="creature" :type="type"/> -->

        <div class="grid lg:grid-cols-2">

            <div class="flex flex-col">
                <!-- <additional-stats :creature="creature" :type="type" v-if="creature.show_additional_stats"/>

                <actions class="flex-grow" :creature="creature" :type="type"/>

                <dice :creature="creature" :disabled="disabled" v-if="creature.show_dice"/> -->
            </div>


        </div>
    </div>
</template>

<script>
    import SimpleHeading from '@/Components/Creature/SimpleHeading'
    import Stats from '@/Components/Creature/Stats'
    import Spells from '@/Components/Creature/Spells'
    import Resources from '@/Components/Creature/Resources'
    import Modifiers from '@/Components/Creature/Modifiers'
    import Actions from '@/Components/Creature/Actions'
    import Notepad from '@/Components/Creature/Notepad'
    import Dice from '@/Components/Dice'
    import AdditionalStats from '@/Components/Creature/AdditionalStats'

    import { CreatureComponent } from '@/Mixins/CreatureComponent';

    export default {
        components: {
            SimpleHeading,
            Stats,
            Spells,
            Resources,
            Modifiers,
            Actions,
            Notepad,
            Dice,
            AdditionalStats,
        },
        mixins: [CreatureComponent],
        methods: {
        }
    }
</script>
