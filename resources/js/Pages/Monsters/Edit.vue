<template>
    <edit :creature="editing" type="Monster"/>
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
