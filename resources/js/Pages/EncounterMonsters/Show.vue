<template>
    <app-layout :title="encounter_monster.display_name ?? encounter_monster.name">
        <template #header>
            {{ encounter_monster.display_name ?? encounter_monster.name }}
        </template>

        <show :creature="encounter_monster" type="Encounter Monster"/>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Show from '@/Components/Creature/Show'

    export default {
        props: ['encounter_monster'],
        components: {
            AppLayout,
            Show,
        }
    }
</script>
