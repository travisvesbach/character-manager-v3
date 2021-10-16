<template>
    <grid-section title="Dice">
        <div class="flex flex-row flex-wrap justify-between">
            <div class="text-center m-2" v-for="dice in dice_sizes">
                <jet-secondary-button size="sm" @click="roll(dice)" :disabled="disabled">
                    1d{{ dice }}
                </jet-secondary-button>
            </div>
        </div>
    </grid-section>
</template>

<script>
    import GridSection from '@/Components/GridSection'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    import { Flash } from '@/Mixins/Flash';
    import { CreatureComponent } from '@/Mixins/CreatureComponent';

    export default {
        components: {
            GridSection,
            JetSecondaryButton
        },
        data() {
            return {
                dice_sizes: [
                    4,
                    6,
                    8,
                    10,
                    12,
                    20,
                    100,
                ],
            }
        },
        mixins: [Flash, CreatureComponent],
        methods: {
            roll(size) {
                let result = dice.roll(size);

                this.flash(this.creature.name + ' rolled 1d' + size + ': ' + result, 'primary');
            }
        }
    }
</script>
