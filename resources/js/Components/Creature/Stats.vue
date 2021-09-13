<template>
    <div>
        <div>
            <p>AC: {{ creature.ac }} <span class="text-xs">({{ creature.ac_source }})</span></p>
            <div class="inline-block cursor-pointer" @click="roll('Initiative', creature.initiative)">
                Initiative: {{ creature.initiative }}
            </div>
            <p>Speed: {{ creature.speed }}</p>
            <div>
                Hit Dice:
                <div v-for="hit_dice in creature.hit_dice">
                    {{ hit_dice.current }}/{{ hit_dice.total }}d{{ hit_dice.size }}
                </div>
            </div>
            <div>
                HP:

            </div>
        </div>
        <div>
        </div>
    </div>
</template>

<script>
    import { flash } from '@/Mixins/Flash';

    export default {
        props: ['creature'],
        components: {

        },
        mixins: [flash],
        methods: {
            roll(item, modifier) {
                let result =  dice.roll();
                let message = this.creature.name + ':<br>' +
                    item + ': [' + result + ']' + (modifier ? ' + ' + modifier : '') + ' = ' + (result + modifier);
                this.flash(message, 'primary');
            }
        }
    }
</script>
