<template>
    <grid-section title="Dice">
        <div class="flex flex-row flex-wrap justify-between">
            <div class="text-center m-2" v-for="dice in dice_sizes">
                <jet-secondary-button size="sm" @click="roll(dice)">
                    1d{{ dice }}
                </jet-secondary-button>
            </div>
        </div>
    </grid-section>
</template>

<script>
    import GridSection from '@/Components/GridSection'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    import { flash } from '@/Mixins/Flash';

    export default {
        props: ['creature', 'type'],
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
        mixins: [flash],
        methods: {
            roll(size) {
                let result = dice.roll(size);

                this.flash(this.creature.name + ' rolled 1d' + size + ': ' + result, 'primary');
            }
        }
    }
</script>
