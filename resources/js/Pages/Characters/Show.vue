<template>
    <app-layout :title="character.name">
        <template #header>
            {{ character.name }}
        </template>

        <template #subheader>
            <div class="flex items-center px-10">
                <jet-nav-link :href="creature.path" :active="creature.id == character.id" preserve-state v-for="creature in characters" :title="'Level ' + creature.level + ' ' +  creature.race + ' ' +  creature.class">
                    {{ creature.name }}
                </jet-nav-link>
            </div>
        </template>

        <show :creature="character" :type="'Character'"/>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import Show from '@/Components/Creature/Show'

    export default {
        props: ['character', 'characters'],
        components: {
            AppLayout,
            JetNavLink,
            Show,
        }
    }
</script>
