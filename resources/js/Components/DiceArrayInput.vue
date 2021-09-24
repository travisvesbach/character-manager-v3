<template>
    <div v-for="(object, index) in modelValue">
        <dice-input id="hit_dice" class="mt-1 inline-block" v-model:count="object.count" v-model:size="object.size" v-model:modifier="object.modifier" v-model:type="object.type" @input="update(object)"/>
        <jet-secondary-button class="ml-2" @click.prevent="modelValue.splice(index, 1)" v-if="modelValue && modelValue.length > 1" title="Remove Dice">&#x2212</jet-secondary-button>
        <jet-secondary-button class="ml-2" @click.prevent="add" v-if="multiple && index+1 == modelValue.length" title="Add Dice">+</jet-secondary-button>
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
                default: true,
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
                if(this.current) {
                    dice.current = dice.count;
                }
                this.$emit('update:modelValue', this.modelValue)
            }
        }
    }
</script>
