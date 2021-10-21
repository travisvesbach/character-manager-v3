<template>
    <app-layout title="encounters">
        <template #header>
            Encounters
        </template>

        <div class="w-full md:w-3/4 xl:w-1/2 mx-auto pb-10 sm:px-6 lg:px-8 m-2">

            <div class="flex mb-1 mx-2 items-end">
                <div class="flex items-end">
                    <encounter-icon class="h-8 w-8"/>
                    <span class="ml-1">{{ encounters.length }} {{ encounters.length == 1 ? 'encounter' : 'encounters' }}</span>
                </div>

                <jet-input class="ml-auto mr-2 p-1" type="text" v-model="search" placeholder="search"/>

                <Link :href="route('encounters.create')" class="btn btn-primary" :as="'button'">
                        New Encounter
                </Link>
            </div>

            <div class="border-b-2 w-full border-color"></div>
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-color">
                        <th class="p-1 text-left">Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-color hover-trigger" v-for="encounter in filtered">
                        <td class="py-2 px-1">
                            <Link :href="encounter.path" class="text-lg link-color" v-html="highlight(encounter.name)"/>
                        </td>
                        <td class="py-2 px-1" v-if="ownerOrAdmin(encounter)">
                            <!-- dropdown -->
                            <jet-dropdown align="right" width="48" class="hover-target">
                                <template #trigger>
                                    <button class="ml-auto flex link link-color">
                                        <svg class="fill-current h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <div>
                                        <jet-dropdown-link :href="route('encounters.edit', encounter.id)">
                                            Edit Encounter
                                        </jet-dropdown-link>
                                        <jet-dropdown-link @click.native="delete_encounter = encounter" as="button">
                                            Delete Encounter
                                        </jet-dropdown-link>
                                    </div>
                                </template>
                            </jet-dropdown>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- delete confirmation -->
        <jet-confirmation-modal :show="delete_encounter" @close="delete_encounter = false">
            <template #title>
                Delete Encounter
            </template>

            <template #content>
                Are you sure you want to delete this encounter?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="delete_encounter = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteEncounter">
                    Delete Encounter
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import { Link } from '@inertiajs/inertia-vue3'
    import EncounterIcon from '@/Components/Icons/Encounter'

    export default {
        props: ['encounters'],

        components: {
            AppLayout,
            JetDropdown,
            JetDropdownLink,
            JetButton,
            JetSecondaryButton,
            JetDangerButton,
            JetConfirmationModal,
            JetInput,
            Link,
            JetCheckbox,
            JetLabel,
            EncounterIcon,
        },
        data() {
            return {
                search: null,
                delete_encounter: false,
            }
        },
        computed: {
            filtered() {
                let result = this.encounters;
                if(this.search) {
                    let searching = this.search.toLowerCase();
                    console.log('here');
                    result = result.filter(function(encounter) {
                        if (encounter.name.toLowerCase().includes(searching)) {
                            return true;
                        } else {
                            return false;
                        }
                    });
                }
                return result;
            },
        },
        methods: {
            ownerOrAdmin(encounter) {
                if(this.$page.props.user.id == encounter.user_id || this.$page.props.user.admin) {
                    return true;
                }
                return false;
            },
            highlight(content) {
                if(!this.search) {
                    return content;
                }
                return content.replace(new RegExp(this.search, "gi"), match => {
                    return '<span class="highlight">' + match + '</span>';
                });
            },
            deleteEncounter() {
                let form = this.$inertia.form({
                    id: this.delete_encounter.id,
                });
                form.delete(route('encounters.destroy', form.id));
            },
        }
    }
</script>
