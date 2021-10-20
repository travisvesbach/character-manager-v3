<template>
    <div class="border-t border-color pt-1 mt-1">
        <textarea id="notes" class="w-full h-full p-0 form-input bg-transparent dark:bg-transparent" style="min-height: 6rem;" v-model="notes" @blur="update" :disabled="!ownerOrAdmin"/>
    </div>
</template>

<script>
    import { CreatureNotepad } from '@/Mixins/Creature/Notepad';

    export default {
        mixins: [CreatureNotepad],
    }
</script>
