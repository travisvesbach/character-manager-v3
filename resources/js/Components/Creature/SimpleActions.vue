<template>
    <div class="border-t border-color pt-1 mt-1">
        <div class="" :class="index != 0 ? 'mt-1 border-t dark:border-gray-600 pt-1' : ''" v-for="(action, index) in creature.actions">
            <div class="flex">
                <div class="whitespace-nowrap">
                    <span class="pr-1" :title="action.type">
                        {{ action.name }}
                    </span>
                    <span class="border-l-2 dark:border-gray-600 px-1" title="Range">
                        {{ action.range }}
                    </span>
                </div>
                <div>
                    <div v-if="action.attack">
                        <span class="border-l-2 dark:border-gray-600 px-1" title="Attack modifier">
                            {{ action.attack_modifier > 0 ? '+' : '' }}{{ action.attack_modifier }}
                        </span>
                        <span class="border-l-2 dark:border-gray-600 px-1" title="Attack damage" v-if="action.attack_does_damage">
                            <span v-for="(dice, index) in action.attack_dice">
                                {{ index > 0 ? ' &' : '' }} {{ dice.type }}
                            </span>
                        </span>
                    </div>
                    <div v-if="action.save">
                        <span class="border-l-2 dark:border-gray-600 px-1" title="Save DC and saving throw type">
                            {{ action.save_dc ? 'DC ' + action.save_dc : '' }} {{ action.save_type }}
                        </span>
                        <span class="border-l-2 dark:border-gray-600 px-1" title="Save damage" v-if="action.save_does_damage">
                            <span v-for="(dice, index) in action.save_dice">
                                {{ index > 0 ? ' &' : '' }} {{ dice.type }}
                            </span>
                        </span>
                    </div>
                </div>
                <div class="ml-auto mt-0.5 flex items-start" :class="disabled ? 'hidden' : ''">
                    <jet-secondary-button class="mr-1" size="xs" @click="roll(action, 'disadvantage')" v-if="action.attack">
                        -
                    </jet-secondary-button>
                    <jet-secondary-button size="xs" @click="roll(action)">
                        Roll
                    </jet-secondary-button>
                    <jet-secondary-button class="ml-1" size="xs" @click="roll(action, 'advantage')" v-if="action.attack">
                        +
                    </jet-secondary-button>
                </div>
            </div>
            <accordion class="pl-4" :class="action.save && (action.attack || action.auto) ? '-mt-6' : ''" v-if="action.notes">
                <accordion-item justify="start" icon_size="sm" button_width="w-auto">
                    <template v-slot:title>
                        <span class="text-sm font-medium mr-2">Notes</span>
                    </template>
                    <template v-slot:content>
                        {{ action.notes }}
                    </template>
                </accordion-item>
            </accordion>
        </div>
    </div>
</template>

<script>
    import { CreatureActions } from '@/Mixins/Creature/Actions';

    export default {
        mixins: [CreatureActions],
    }
</script>
