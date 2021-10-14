<template>
    <grid-section title="Notepad">
        <textarea id="notes" class="w-full h-full p-0 form-input bg-transparent dark:bg-transparent" v-model="notes" @blur="update"></textarea>
    </grid-section>
</template>

<script>
    import GridSection from '@/Components/GridSection'
    import JetCheckbox from '@/Jetstream/Checkbox'

    import { flash } from '@/Mixins/Flash';
    import { creatureEmit } from '@/Mixins/Creature/Emit';

    export default {
        props: ['creature', 'type'],
        components: {
            GridSection
        },
        data() {
            return {
                notes: this.creature.notes,
            }
        },
        mixins: [flash, creatureEmit],
        methods: {
            update() {
                if(this.notes != this.creature.notes) {
                    this.creature.notes = this.notes;
                    this.updateCreature(true);
                }
            }
        }
    }
</script>
