<template>
    <div class="mt-2">
        <checkbox :id="getSlug + '_proficiency'" v-model="proficiency" :title="'Proficiency'" @input="updateProficiency($event.target.checked)"/>
        <checkbox :id="getSlug + '_expertise'" class="ml-1" :class="(expertise == 'hidden' ? 'invisible' : '')" v-model="expertise" :title="'Expertise'" @input="updateExpertise($event.target.checked)"/>
        <jet-label :for="getSlug + '_proficiency'" :value="label" class="inline-block ml-1" />
    </div>
</template>

<script>
    import JetLabel from '@/Jetstream/Label'
    import Checkbox from '@/Components/Checkbox'


    export default {
        props: {
            proficiency: {},
            expertise: {
                default: 'hidden',
            },
            label: {},
            slug: {},
        },
        components: {
            JetLabel,
            Checkbox,
        },
        emits: ['update:modelValue'],
        computed: {
            getSlug() {
                if(this.slug) {
                    return this.slug;
                }
                return this.label.toLowerCase()
                    .replace(/[^\w ]+/g,'')
                    .replace(/ +/g,'-');
            }
        },
        methods: {
            focus() {
                this.$refs.input.focus()
            },
            updateProficiency(checked = false) {
                if(this.expertise && !checked) {
                    this.$emit('update:expertise', false);
                }
                this.$emit('update:proficiency', checked)
            },
            updateExpertise(checked = false) {
                if(!this.proficiency && checked) {
                    this.$emit('update:proficiency', true);
                }
                this.$emit('update:expertise', checked)
            }
        }
    }
</script>
