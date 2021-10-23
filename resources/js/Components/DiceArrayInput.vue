<template>
    <div v-for="(object, index) in modelValue" class="mt-1 flex">
        <dice-input id="hit_dice" class="inline-block" v-model:count="object.count" v-model:size="object.size" v-model:modifier="object.modifier" v-model:type="object.type" :same="same" @input="update(object)"/>
        <jet-secondary-button class="ml-2" @click.prevent="modelValue.splice(index, 1)" v-if="modelValue && modelValue.length > 1" title="Remove Dice">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
        </jet-secondary-button>
        <jet-secondary-button class="ml-2" @click.prevent="add" v-if="multiple && index+1 == modelValue.length" title="Add Dice">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </jet-secondary-button>
    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import DiceInput from '@/Components/DiceInput'

    export default {
        components: {
            JetButton,
            JetSecondaryButton,
            DiceInput,
        },
        props: {
            modelValue: {},
            current: {
                type: Boolean,
                default: false,
            },
            multiple: {
                type: Boolean,
                default: false,
            },
            same: {
                type: Boolean,
                default: false,
            }
        },
        emits: ['update:modelValue'],
        methods: {
            add() {
                this.modelValue.push({});
                Object.keys(this.modelValue[0]).forEach(function(key,index) {
                    this.modelValue[this.modelValue.length - 1][key] = null;
                }, this);
            },
            update(dice) {
                if(dice.count) {
                    dice.count = getNumber(dice.count);
                }
                if(dice.size) {
                    dice.size = getNumber(dice.size);
                }
                if(dice.modifier) {
                    dice.modifier = getNumber(dice.modifier);
                }
                if(this.current) {
                    dice.current = dice.count;
                }
                this.$emit('update:modelValue', this.modelValue)
            }
        }
    }
</script>
