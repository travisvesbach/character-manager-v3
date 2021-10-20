<template>
    <grid-section title="Notepad">
        <textarea id="notes" class="w-full h-full p-0 form-input bg-transparent dark:bg-transparent" style="min-height: 12rem;" v-model="notes" @blur="update" :disabled="!ownerOrAdmin"/>
    </grid-section>
</template>

<script>
    import GridSection from '@/Components/GridSection'

    import { CreatureNotepad } from '@/Mixins/Creature/Notepad';

    export default {
        components: {
            GridSection
        },
        mixins: [CreatureNotepad]
    }
</script>
