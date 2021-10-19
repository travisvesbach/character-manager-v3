<template>
    <grid-section title="Additional Stats">
        <div class="">
            <div v-if="creature.damage_vulnerabilities">
                <strong>Damage Vulnerabilities:</strong> {{ creature.damage_vulnerabilities }}
            </div>
            <div v-if="creature.damage_resistances">
                <strong>Damage Resistances:</strong> {{ creature.damage_resistances }}
            </div>
            <div v-if="creature.damage_immunities">
                <strong>Damage Immunities:</strong> {{ creature.damage_immunities }}
            </div>
            <div v-if="creature.condition_immunities">
                <strong>Condition Immunities:</strong> {{ creature.condition_immunities }}
            </div>
            <div v-if="creature.languages">
                <strong>Languages:</strong> {{ creature.languages }}
            </div>
            <div v-if="creature.senses">
                <strong>Senses:</strong> {{ creature.senses }}
            </div>
            <div v-if="creature.experience">
                <strong>Experience:</strong> {{ creature.experience }}
            </div>
            <div v-if="creature.source">
                <strong>Source:</strong> {{ creature.source }}
            </div>
        </div>
    </grid-section>
</template>

<script>
    import GridSection from '@/Components/GridSection'

    import { CreatureBase } from '@/Mixins/Creature/Base';

    export default {
        components: {
            GridSection
        },
        mixins: [CreatureBase],
    }
</script>
