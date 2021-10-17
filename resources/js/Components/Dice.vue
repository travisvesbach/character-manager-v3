<template>
    <grid-section title="Dice">
        <div class="flex flex-row flex-wrap justify-between">
            <jet-input type="number" class="m-1 p-1 text-center text-xs w-10" v-model.number="count" :disabled="disabled"/>
            <div class="text-center m-1" v-for="size in sizes">
                <jet-secondary-button size="sm" @click="roll(size)" :disabled="disabled">
                    d{{ size }}
                </jet-secondary-button>
            </div>
        </div>
    </grid-section>
</template>

<script>
    import GridSection from '@/Components/GridSection'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetInput from '@/Jetstream/Input'

    import { Flash } from '@/Mixins/Flash';

    export default {
        props: {
            disabled: {
                default: false,
            },
            creature: {
                default: null
            }
        },
        components: {
            GridSection,
            JetSecondaryButton,
            JetInput
        },
        data() {
            return {
                sizes: [
                    4,
                    6,
                    8,
                    10,
                    12,
                    20,
                    100,
                ],
                count: 1,
            }
        },
        mixins: [Flash],
        methods: {
            roll(size) {
                let results = [];
                let total = 0;
                for(let i=0;i<this.count;i++) {
                    let result = dice.roll(size);
                    total += result;
                    results.push(result);
                }

                this.flash((this.creature ? this.creature.name + ' rolled ' : '') + this.count + 'd' + size + ': ' + JSON.stringify(results) + ' = ' + total, 'primary');
            }
        }
    }
</script>
