<template>
    <grid-section title="Notepad">
        <textarea id="notes" class="w-full h-full p-0 form-input bg-transparent dark:bg-transparent" style="min-height: 12rem;" v-model="notes" @blur="update" :disabled="!ownerOrAdmin"/>
    </grid-section>
</template>

<script>
    import GridSection from '@/Components/GridSection'
    import JetCheckbox from '@/Jetstream/Checkbox'

    import { Flash } from '@/Mixins/Flash';
    import { CreatureComponent } from '@/Mixins/Creature/Component';

    export default {
        components: {
            GridSection
        },
        data() {
            return {
                notes: this.creature.notes,
            }
        },
        mixins: [Flash, CreatureComponent],
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
