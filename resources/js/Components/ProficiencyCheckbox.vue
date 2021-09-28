<template>
    <div class="mt-2">
        <jet-checkbox :id="getSlug + '_proficiency'" v-model:checked="proficiency" :title="'Proficiency'" @input="updateProficiency($event.target.checked)"/>
        <jet-checkbox :id="getSlug + '_expertise'" class="ml-1" :class="(expertise == 'hidden' ? 'invisible' : '')" v-model:checked="expertise" :title="'Expertise'" @input="updateExpertise($event.target.checked)" v-if="expertise != 'hidden'"/>
        <jet-label :for="getSlug + '_proficiency'" :value="label" class="inline-block ml-1" />
    </div>
</template>

<script>
    import JetLabel from '@/Jetstream/Label'
    import JetCheckbox from '@/Jetstream/Checkbox'


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
            JetCheckbox,
        },
        emits: ['update:proficiency', 'update:expertise'],
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
