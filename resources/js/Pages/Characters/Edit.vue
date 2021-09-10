<template>
    <app-layout>
        <template #header>
            {{ editing && editing.name ? 'Edit ' + editing.name : 'Create Character' }}
        </template>

        <centered-form @submitted="submit">

            <!-- Name -->
            <jet-label for="name" value="Name" />
            <jet-input type="text" id="name" class="mt-1 block w-full" v-model="form.name" required/>
            <jet-input-error :message="form.errors.name" class="mt-2" />

            <!-- Race -->
            <jet-label for="race" value="Race" class="mt-4" />
            <jet-input type="text" id="race" class="mt-1 block w-full" v-model="form.race" required/>
            <jet-input-error :message="form.errors.race" class="mt-2" />

            <!-- Class -->
            <jet-label for="class" value="Class" class="mt-4" />
            <jet-input type="text" id="class" class="mt-1 block w-full" v-model="form.class" required/>
            <jet-input-error :message="form.errors.class" class="mt-2" />

            <!-- level -->
            <jet-label for="level" value="Level" class="mt-4" />
            <jet-input type="number" id="level" class="mt-1 block w-full" v-model="form.level" required/>
            <jet-input-error :message="form.errors.level" class="mt-2" />

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
    import CenteredForm from '@/Components/CenteredForm'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import SelectInput from '@/Components/SelectInput'
    import Checkbox from '@/Components/Checkbox'

    export default {
        props: ['editing'],

        components: {
            AppLayout,
            JetActionMessage,
            JetButton,
            CenteredForm,
            JetInput,
            JetInputError,
            JetLabel,
            SelectInput,
            Checkbox,
        },
        data() {
            return {
                form: this.$inertia.form({
                    id: null,
                    name: null,
                    race: null,
                    class: null,
                    level: 0,
                }),
            }
        },
        created() {
            if(this.editing) {
                this.form = this.$inertia.form({
                    id: this.editing.id,
                    name: this.editing.name,
                    race: this.editing.race,
                    class: this.editing.class,
                    level: this.editing.level,
                });
            }
        },
        methods: {
            submit() {
                if(this.editing) {
                    this.form.patch(route('characters.update', this.form.id));
                } else {
                    this.form.post(route('characters.store'));
                }
            },
        },
    }
</script>
