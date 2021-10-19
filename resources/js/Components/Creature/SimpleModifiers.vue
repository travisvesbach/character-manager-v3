<template>
    <div class="border-t border-color pt-1 mt-1 flex justify-between flex-wrap">
        <div class="mx-1" v-for="(modifier, index) in creature.modifiers">
            <label class="cursor-pointer" :for="'enable_' + modifier.name">
                {{ modifier.name }}
            </label>
            <jet-checkbox :id="'enable_' + modifier.name" class="ml-1" :class="disabled ? 'hidden' : ''" v-model:checked="modifier.enabled" @change.native="toggleEnabled(modifier)"/>
        </div>
    </div>
</template>

<script>
    import JetCheckbox from '@/Jetstream/Checkbox'

    import { CreatureBase } from '@/Mixins/Creature/Base';
    import { CreatureModifiers } from '@/Mixins/Creature/Modifiers';

    export default {
        components: {
            JetCheckbox,
        },
        mixins: [CreatureBase, CreatureModifiers],
    }
</script>
