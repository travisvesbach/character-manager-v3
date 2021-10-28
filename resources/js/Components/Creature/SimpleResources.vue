<template>
    <div class="border-t border-color pt-1 mt-1">
        <div :class="index != 0 ? 'my-1' : 'mb-1'" v-for="(resource, index) in creature.resources">
            <div class="flex justify-between">
                <span>
                    {{ resource.name }}:
                </span>
                <span v-if="resource.type == 'counter' && resource.counter_type == 'slots'">
                    <counter-slot v-for="(slot, index) in resource.slots" :slot="slot" @click.native="updateSlot(resource, index)" :disabled="disabled"/>
                </span>
                <span v-if="resource.type == 'counter' && resource.counter_type == 'points'">
                    <jet-input type="number" class="w-16 p-1" v-model.number="resource.current" @input="updateCreature" v-if="!disabled"/> <span v-if="!disabled">/</span> {{ resource.total }}
                </span>
                <jet-secondary-button size="xs" class="ml-auto inline-block" @click="rollDice(resource)" v-if="resource.type == 'dice'" :disabled="disabled">
                    <span v-for="(dice, index) in resource.dice" :class="index > 0 ? 'ml-1' : ''">
                        {{ dice.count }}d{{ dice.size }}{{ dice.modifier ? '+' + dice.modifier : '' }}
                    </span>
                </jet-secondary-button>
                <jet-secondary-button size="xs" class="ml-auto inline-block" @click="rollTable(resource.dice_table)" v-if="resource.type == 'dice table'" :disabled="disabled">
                    Roll
                </jet-secondary-button>
            </div>
        </div>
    </div>
</template>

<script>
    import { CreatureResources } from '@/Mixins/Creature/Resources'
    import { DiceTableRoll } from '@/Mixins/DiceTableRoll'

    export default {
        mixins: [CreatureResources, DiceTableRoll],
    }
</script>
