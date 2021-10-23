                }),
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
                <jet-button size="sm" class="ml-2" title="Party members" @click="openPartyModal">
                    <character-icon class="h-6 w-6"/>
                </jet-button>
            </div>

            <div class="border-b-2 w-full border-color"></div>
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-color">
                        <th class="p-1 text-left">Name</th>
                        <th class="p-1 text-left">Monsters</th>
                        <th class="p-1 text-left">Experience</th>
                        <th class="p-1 text-left">Difficulty</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-color hover-trigger" v-for="encounter in filtered">
                        <td class="py-2 px-1">
                            <Link :href="encounter.path" class="text-lg link-color" v-html="highlight(encounter.name)"/>
                        </td>
                        <td class="py-2 px-1" v-html="encounter.monsters_count"/>
                        <td class="py-2 px-1" v-html="encounter.experience"/>
                        <td class="py-2 px-1" v-html="encounter.difficulty"/>
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

        <!-- party modal -->
        <jet-dialog-modal :show="show_party" type="form" max-width="lg" @close="show_party = false" @submitted="updateParty">
            <template #header>
                Party Members
            </template>

            <template #content>
                Add party members and set thier levels.

                <div class="mt-4">
                        <div class="grid grid-cols-3 gap-x-2">
                            <jet-label for="level" class="mt-2" value="Number of Characters"/>
                            <jet-label for="level" class="mt-2" value="Character Level"/>
                        </div>
                    <div v-for="(obj, index) in form.party">
                        <div class="mt-1 grid grid-cols-3 gap-x-2">
                            <jet-input type="number" class="inline-block" v-model.number="obj.count" required/>
                            <jet-input type="number" class="inline-block" v-model.number="obj.level" required/>
                            <div>
                                <jet-secondary-button class="mr-2 mt-0.5" @click.prevent="form.party.splice(index, 1)" v-if="form.party && form.party.length > 1" title="Remove Party Member">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </jet-secondary-button>
                                <jet-secondary-button class="mt-0.5" @click.prevent="addParty" v-if="index+1 == form.party.length" title="Add Party Member">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </jet-secondary-button>
                            </div>
                        </div>
                    </div>
                    <jet-input-error :message="form.errors.party" class="mt-2"/>
                </div>
            </template>

            <template #footerend>
                <jet-secondary-button @click="show_party = false;">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </jet-button>
            </template>
        </jet-dialog-modal>

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
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import { Link } from '@inertiajs/inertia-vue3'
    import EncounterIcon from '@/Components/Icons/Encounter'
    import CharacterIcon from '@/Components/Icons/Character'

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
            JetDialogModal,
            JetInput,
            JetInputError,
            Link,
            JetCheckbox,
            JetLabel,
            EncounterIcon,
            CharacterIcon,
        },
        data() {
            return {
                search: null,
                delete_encounter: false,
                show_party: false,
                form: this.$inertia.form({
                    party: [],
                }),
            }
        },
        computed: {
            filtered() {
                let result = this.encounters;
                if(this.search) {
                    let searching = this.search.toLowerCase();
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
            openPartyModal() {
                this.form.party = this.$page.props.user.party ? JSON.parse(JSON.stringify(this.$page.props.user.party)) : [{ count: null, level: null }];
                this.show_party = true;
            },
            addParty() {
                this.form.party.push({ count: null, level: null });
            },
            updateParty() {
                this.form.patch(route('users.party', this.$page.props.user.id), {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.show_party = false;
                    }
                });
            }
        }
    }
</script>
