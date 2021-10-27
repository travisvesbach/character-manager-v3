<template>
    <app-layout :title="editing && editing.name ? 'Edit ' + editing.name : 'Create Dice Table'">
        <template #header>
            {{ editing && editing.name ? 'Edit ' + editing.name : 'Create Dice Table' }}
        </template>

        <centered-form @submitted="submit" width="1/2">
            <div class="grid sm:grid-cols-2">
                <div class="col-span-1 px-1">
                    <!-- name -->
                    <jet-label for="name" value="Name" class="mt-4"/>
                    <jet-input type="text" id="name" class="mt-1 w-full" v-model="form.name" required/>
                    <jet-input-error :message="form.errors.name" class="mt-2"/>
                </div>

                <div class="col-span-1 px-1">
                    <!-- public -->
                    <jet-label for="public" value="Visibility" class="mt-4"/>
                    <select-input id="public" class="mt-1 w-full" v-model="form.public" :options="[[1, 'Public'], [0, 'Private']]" required/>
                    <jet-input-error :message="form.errors.public" class="mt-2"/>
                </div>
            </div>

            <div class="mt-4">
                <p class="mb-2">
                    Enter in dice table information below.  If a result only has one number, leave the range end blank.
                </p>
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-color">
                            <th class="p-1 text-left">Range Start</th>
                            <th class="p-1 text-left">Range End</th>
                            <th class="py-1 px-1 text-left">Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b-2 border-color hover-trigger" v-for="(obj, index) in form.rows">
                            <td class="py-2 px-1">
                                <jet-input type="number" class="w-20" placeholder="start" v-model.number="obj.range[0]" required/>
                            </td>
                            <td class="py-2 px-1">
                                <jet-input type="number" class="w-20" placeholder="end" v-model.number="obj.range[1]"/>
                            </td>
                            <td class="py-2 px-1">
                                <textarea  class="form-input w-full"  placeholder="roll result" v-model.number="obj.result"/>
                            </td>
                            <td class="py-2 px-1">
                                <jet-secondary-button class="mr-2 mt-0.5" @click.prevent="form.rows.splice(index, 1)" v-if="form.rows && form.rows.length > 1" title="Remove Row">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </jet-secondary-button>
                                <jet-secondary-button class="mt-0.5" @click.prevent="form.rows.push({ range: [null,null], result: null })" v-if="index+1 == form.rows.length" title="Add Row">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </jet-secondary-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <jet-input-error :message="form.errors.rows" class="mt-2"/>
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
    import SelectInput from '@/Components/SelectInput'

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
            SelectInput,
        },
        data() {
            return {
                form: this.$inertia.form({
                    id: null,
                    name: null,
                    public: null,
                    rows: [{
                        range: [null,null],
                        result: null,
                    }],
                }),
            }
        },
        created() {
            if(this.editing) {
                this.form = this.$inertia.form({
                    id: this.editing.id,
                    name: this.editing.name,
                    public: this.editing.public,
                    rows: this.editing.rows,
                });
            }
        },
        methods: {
            submit() {
                if(this.editing) {
                    this.form.patch(route('dice_tables.update', this.form.id));
                } else {
                    this.form.post(route('dice_tables.store'));
                }
            },
        },
    }
</script>
