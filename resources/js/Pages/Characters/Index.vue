<template>
    <app-layout title="characters">
        <template #header>
            Characters
        </template>

        <div class="w-full md:w-3/4 xl:w-1/2 mx-auto pb-10 sm:px-6 lg:px-8 m-2">

            <div class="flex mb-1 mx-2 items-end">
                <div class="flex items-center">
                    <svg class="h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="ml-1">{{ characters.length }} {{ characters.length == 1 ? 'character' : 'characters' }}</span>
                </div>

                <div class="ml-auto">
                    <jet-checkbox id="show_archived" v-model:checked="show_archived"/>
                    <jet-label class="inline-block ml-1" for="show_archived" value="Show Archived"/>
                </div>

                <jet-input class="mx-2 p-1" type="text" v-model="search" placeholder="search"/>

                <Link :href="route('characters.create')" class="btn btn-primary" :as="'button'">
                        New Character
                </Link>
            </div>

            <div class="border-b-2 w-full border-color"></div>
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-color">
                        <th class="p-1 text-left">Name</th>
                        <th class="p-1 text-left">Class</th>
                        <th class="p-1 text-left">Race</th>
                        <th class="p-1 text-left">Level</th>
                        <th class="p-1 text-left">Archive Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-color hover-trigger" v-for="character in filteredData">
                        <td class="py-2 px-1">
                            <Link :href="character.path" class="text-lg link-color" v-html="highlight(character.name)"/>
                        </td>
                        <td class="py-2 px-1" v-html="highlight(character.class)"/>
                        <td class="py-2 px-1" v-html="highlight(character.race)"/>
                        <td class="py-2 px-1">
                            {{ character.level }}
                        </td>
                        <td class="py-2 px-1">
                            {{ character.archive_date ?? '' }}
                        </td>
                        <td class="py-2 px-1" v-if="ownerOrAdmin(character)">
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
                                        <jet-dropdown-link @click.native="toggleArchive(character)" as="button">
                                            Archive Character
                                        </jet-dropdown-link>
                                        <jet-dropdown-link :href="route('characters.edit', character.id)">
                                            Edit Character
                                        </jet-dropdown-link>
                                        <jet-dropdown-link @click.native="delete_character = character" as="button">
                                            Delete Character
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
        <jet-confirmation-modal :show="delete_character" @close="delete_character = false">
            <template #title>
                Delete Character
            </template>

            <template #content>
                Are you sure you want to delete this character?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="delete_character = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deletecharacter">
                    Delete Character
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Badge from '@/Components/Badge'
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

    export default {
        props: ['characters'],

        components: {
            AppLayout,
            Badge,
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
        },
        data() {
            return {
                search: null,
                show_archived: false,
                delete_character: false,
            }
        },
        computed: {
            filteredData() {
                let result = this.characters.filter(function(character) {
                    if(!this.show_archived && character.archive_date) {
                        return false;
                    } else {
                        return true;
                    }
                }, this);
                if(this.search) {
                    let searching = this.search.toLowerCase();
                    console.log('here');
                    result = result.filter(function(character) {
                        if (character.name.toLowerCase().includes(searching) || character.class.toLowerCase().includes(searching) || character.race.toLowerCase().includes(searching)) {
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
            ownerOrAdmin(character) {
                if(this.$page.props.user.id == character.user_id || this.$page.props.user.admin) {
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
            deleteCharacter() {
                let form = this.$inertia.form({
                    id: this.delete_character.id,
                });
                form.delete(route('characters.destroy', form.id));
                this.delete_character = false;
            },
            toggleArchive(character) {
                let form = this.$inertia.form({
                    id: character.id,
                });
                if(!character.archive_date) {
                    form.patch(route('characters.archive', character.id));
                } else {
                    form.patch(route('characters.unarchive', character.id));
                }
            }
        }
    }
</script>
