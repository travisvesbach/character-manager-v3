<template>
    <app-layout :title="editing && editing.name ? 'Edit ' + editing.name : 'Create User'">
        <template #header>
            {{ editing && editing.name ? 'Edit ' + editing.name : 'Create User' }}
        </template>

        <centered-form @submitted="submit">

            <!-- Name -->
            <jet-label for="name" value="Name" />
            <jet-input type="text" id="name" class="mt-1 block w-full" v-model="form.name" required/>
            <jet-input-error :message="form.errors.name" class="mt-2" />

            <!-- Email -->
            <jet-label for="email" value="Email" class="mt-4" />
            <jet-input type="email" id="email" class="mt-1 block w-full" v-model="form.email" required/>
            <jet-input-error :message="form.errors.email" class="mt-2" />

            <!-- Password -->
            <jet-label for="password" value="Password" class="mt-4" />
            <jet-input type="password" id="password" class="mt-1 block w-full" v-model="form.password" :required="editing ? false : true"/>
            <jet-input-error :message="form.errors.password" class="mt-2" />

            <!-- Password Confirmation -->
            <jet-label for="password_confirmation" value="Confirm Password" class="mt-4" />
            <jet-input type="password" id="password_confirmation" class="mt-1 block w-full" v-model="form.password_confirmation" :required="editing ? false : true"/>
            <jet-input-error :message="form.errors.password_confirmation" class="mt-2" />

            <!-- Admin -->
            <jet-label for="admin" value="Admin" class="inline-block mr-1 mt-4" />
            <jet-checkbox id="admin" v-model:checked="form.admin"/>
            <jet-input-error :message="form.errors.admin" class="mt-2" />

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
    import JetCheckbox from '@/Jetstream/Checkbox'
    import SelectInput from '@/Components/SelectInput'

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
            JetCheckbox,
        },
        data() {
            return {
                form: this.$inertia.form({
                    id: null,
                    name: null,
                    email: null,
                    admin: false,
                    password: null,
                    password_confirmation: null,
                }),
            }
        },
        created() {
            if(this.editing) {
                this.form = this.$inertia.form({
                    id: this.editing.id,
                    name: this.editing.name,
                    email: this.editing.email,
                    admin: this.editing.admin,
                    password: null,
                    password_confirmation: null,
                });
            }
        },
        methods: {
            submit() {
                if(this.editing) {
                    this.form.patch(route('users.update', this.form.id));
                } else {
                    this.form.post(route('users.store'));
                }
            },
        },
    }
</script>
