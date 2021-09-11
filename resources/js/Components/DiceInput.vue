<template>
    <div>
        <jet-input class="inline-block w-14" type="number" v-model.number="total" @input="this.$emit('update:total', $event.target.value);" v-if="total != 'hidden'" />
        <span class="mx-1">d</span>
        <select-input class="inline-block" v-model="size" :options="sizes" @input="this.$emit('update:size', $event.target.value);" v-if="size != 'hidden'" />
        <span class="mx-1" v-if="modifier != 'hidden'">+</span>
        <jet-input class="inline-block w-14" type="number" v-model.number="modifier" v-if="modifier != 'hidden'" />
        <select-input class="inline-block ml-1" v-model="type" :options="damageTypes" @input="this.$emit('update:type', $event.target.value);" v-if="type != 'hidden'" />
    </div>

</template>

<script>
    import JetInput from '@/Jetstream/Input'
    import SelectInput from '@/Components/SelectInput'

    export default {
        components: {
            JetInput,
            SelectInput,
        },
        props: {
            total: {
                default: 'hidden',
            },
            size: {
                default: 'hidden',
            },
            modifier: {
                default: 'hidden',
            },
            type: {
                default: 'hidden',
            },
            is_modifier: {
                default: false,
            },
        },
        data() {
            return {
                sizes: [
                    4,
                    6,
                    8,
                    10,
                    12,
                    20,
                    100,
                ],
            }
        },
        emits: ['update:total', 'update:size', 'update:modifier', 'update:type'],
        computed: {
            damageTypes() {
                let types = [
                    'Acid',
                    'Bludgeoning',
                    'Cold',
                    'Fire',
                    'Force',
                    'Lightning',
                    'Necrotic',
                    'Piercing',
                    'Poison',
                    'Psychic',
                    'Radiant',
                    'Slashing',
                    'Thunder',
                ];

                if(this.is_modifier) {
                    types.push('Same as attack');
                }
                return types;
            }
        }
    }

</script>
