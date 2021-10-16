<template>
    <show :creature="monster" :type="'Monster'"/>
</template>

<script>
    import Show from '@/Components/Creature/Show'

    export default {
        props: ['monster'],
        components: {
            Show,
        }
    }
</script>
