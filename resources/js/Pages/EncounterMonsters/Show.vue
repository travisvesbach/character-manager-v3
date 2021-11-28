<template>
    <app-layout :title="encounter_monster.display_name ?? encounter_monster.name">
        <template #header>
            {{ encounter_monster.display_name ?? encounter_monster.name }}
        </template>

        <template #subheader>
            <div class="px-10">
                <jet-nav-link :href="encounter_monster.encounter.path" title="Return to encounter">
                    <svg xmlns="https://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ encounter_monster.encounter.name }}
                </jet-nav-link>
            </div>
        </template>

        <show :creature="encounter_monster" type="Encounter Monster"/>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Show from '@/Components/Creature/Show'
    import JetNavLink from '@/Jetstream/NavLink.vue'

    export default {
        props: ['encounter_monster'],
        components: {
            AppLayout,
            Show,
            JetNavLink,
        }
    }
</script>
