<template>
    <div class="col-span-1 border dark:border-gray-700 flex flex-col">
        <div class="p-2 flex justify-between" v-if="title || $slots.button">
            <p class="text-xl flex items-center">
                <character-icon class="h-8 w-8 mr-2" v-if="icon == 'Character'"/>
                <encounter-icon class="h-8 w-8 mr-2" v-if="icon == 'Encounter'"/>
                <monster-icon class="h-8 w-8 mr-2" v-if="icon == 'Monster'"/>
                {{ title }}
            </p>
            <slot name="button"/>
        </div>
        <div class="px-2 p-1 bg-gray-50 border-t dark:bg-gray-800 dark:border-gray-700 flex-grow">
            <slot/>
        </div>
    </div>
</template>

<script>
    import CharacterIcon from '@/Components/Icons/Character'
    import EncounterIcon from '@/Components/Icons/Encounter'
    import MonsterIcon from '@/Components/Icons/Monster'

export default {
    components: {
        CharacterIcon,
        EncounterIcon,
        MonsterIcon,
    },
    props: ['title', 'icon'],
}
</script>
