<template>
    <show :creature="character" :type="'Character'"/>
</template>

<script>
    import Show from '@/Components/Creature/Show'

    export default {
        props: ['character'],
        components: {
            Show,
        }
    }
</script>
