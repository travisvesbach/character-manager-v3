<template>
    <div>
        <div>
            <p>AC: {{ creature.ac }} <span class="text-xs">({{ creature.ac_source }})</span></p>
            <dice :modifier="creature.initiative" :message="creature.name + '\'s initiative: '">
                Initiative: {{ creature.initiative }}
            </dice>
        </div>
        <div>
            <p>Speed: {{ creature.speed }}</p>
            <dice :modifier="creature.initiative" :message="creature.name + '\'s initiative: '">
                Initiative: {{ creature.initiative }}
            </dice>
        </div>
    </div>
</template>

<script>
    import Dice from '@/Components/Dice'

    export default {
        props: ['creature'],
        components: {
            Dice
        },
        methods: {

        }
    }
</script>
