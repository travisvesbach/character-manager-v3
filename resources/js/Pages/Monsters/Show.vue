<template>
    <app-layout :title="monster.name">
        <template #header>
            {{ monster.name }}
        </template>

        <show :creature="monster" type="Monster"/>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Show from '@/Components/Creature/Show'

    export default {
        props: ['monster'],
        components: {
            AppLayout,
            Show,
        }
    }
</script>
