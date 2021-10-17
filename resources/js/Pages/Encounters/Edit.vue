<template>
    <app-layout :title="editing && editing.name ? 'Edit ' + editing.name : 'Create Encounter'">
        <template #header>
            {{ editing && editing.name ? 'Edit ' + editing.name : 'Create Encounter' }}
        </template>

        <centered-form @submitted="submit" width="1/2">
            <div class="px-1">
                <!-- Name -->
                <jet-label for="name" value="Name"/>
                <jet-input type="text" id="name" class="mt-1 w-full" v-model="form.name" required/>
                <jet-input-error :message="form.errors.name" class="mt-2"/>
            </div>

            <template #actions>
                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                    Saved.
                </jet-action-message>
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </jet-button>
            </template>
        </centered-form>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import CenteredForm from '@/Components/CenteredForm'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'

    export default {
        props: ['editing'],
        components: {
            AppLayout,
            JetActionMessage,
            JetButton,
            JetSecondaryButton,
            CenteredForm,
            JetInput,
            JetInputError,
            JetLabel,
        },
        data() {
            return {
                form: this.$inertia.form({
                    id: null,
                    name: null,
                }),
            }
        },
        created() {
            if(this.editing) {
                this.form = this.$inertia.form({
                    id: this.editing.id,
                    name: this.editing.name,
                });
            }
        },
        methods: {
            submit() {
                if(this.editing) {
                    this.form.patch(route('encounters.update', this.form.id));
                } else {
                    this.form.post(route('encounters.store'));
                }
            },
        },
    }
</script>
