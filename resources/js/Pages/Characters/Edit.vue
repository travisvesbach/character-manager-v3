<template>
    <edit :creature="editing" type="Character"/>
</template>

<script>
    import Edit from '@/Components/Creature/Edit'

    export default {
        props: ['editing'],
        components: {
            Edit,
        },
    }
</script>
