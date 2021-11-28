<template>
    <app-layout title="monsters">
        <template #header>
            Monster Library
        </template>

        <div class="w-full md:w-3/4 xl:w-1/2 mx-auto pb-10 sm:px-6 lg:px-8 m-2">

            <div class="flex mb-1 mx-2 items-end">
                <div class="flex items-end">
                    <monster-icon class="h-8 w-8"/>
                    <span class="ml-1">{{ monsters.length }} {{ monsters.length == 1 ? 'monster' : 'monsters' }}</span>
                </div>

                <jet-input class="ml-auto mr-2 p-1" type="text" v-model="search" placeholder="search"/>

                <Link :href="route('monsters.create')" class="btn btn-primary" :as="'button'">
                        New Monster
                </Link>
                <help-modal class="ml-2">
                    <template #header>
                        Monster Library
                    </template>
                    <template #content>
                        <p class="mb-4">
                            Monsters can be added to the Monster Library in order to be used in encounters.
                        </p>
                        <p class="mb-4">
                            Monsters in the library are to be used as a base for encounter monsters.  If you have a monster that has special stats, but only for one encounter, you should add the base monster to the encounter and edit it there.  However, if you have a recurring rival or npc, you can clone the base monster and keep the special one in the library so you don't have to remake that creature repeatedly.
                        </p>
                        <p class="mb-4">
                            Monsters can be marked as Public or Private.  Public monsters are available for everyone to use in their encounters, but only the monster creator or an admin can edit them in the library.  Private monsters are only available to the monster's creator.  If adding a general monster from a sourcebook, it should be added as Public in order so that we don't end up with multiple copies of the same monsters.  Always check to make sure the monster you're going to create doesn't already exist.  An admin will go through on occasion and remove duplicates.
                        </p>
                        <p class="mb-4">
                            Encounters use monsters' experience values to calculate difficulty.  When adding sourcebook monsters, please enter in the correct experience value.  When adding custom monsters, do your best to determine to proper challenge ratings and experience values for those monsters.
                        </p>
                    </template>
                </help-modal>
            </div>

            <div class="border-b-2 w-full border-color"></div>
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-color">
                        <th class="p-1 text-left">Name</th>
                        <th class="p-1 text-left">Type</th>
                        <th class="p-1 text-left">Size</th>
                        <th class="p-1 text-left">CR</th>
                        <th class="p-1 text-left">Visibility</th>
                        <th class="p-1 text-left">Owner</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-color hover-trigger" v-for="monster in filtered">
                        <td class="py-2 px-1">
                            <Link :href="monster.path" class="text-lg link-color" v-html="highlight(monster.name)"/>
                        </td>
                        <td class="py-2 px-1" v-html="highlight(monster.type)"/>
                        <td class="py-2 px-1" v-html="highlight(monster.size)"/>
                        <td class="py-2 px-1">
                            {{ monster.challenge_rating }}
                        </td>
                        <td class="py-2 px-1">
                            {{ monster.public ? 'public' : 'private' }}
                        </td>
                        <td class="py-2 px-1">
                            {{ monster.user.name }}
                        </td>
                        <td class="py-2 px-1" v-if="ownerOrAdmin(monster)">
                            <!-- dropdown -->
                            <jet-dropdown align="right" width="48" class="hover-target">
                                <template #trigger>
                                    <button class="ml-auto flex link link-color">
                                        <svg class="fill-current h-8 w-8" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <div>
                                        <jet-dropdown-link @click.native="clone_monster = monster" as="button">
                                            Clone {{ monster.display_name }}
                                        </jet-dropdown-link>
                                        <jet-dropdown-link :href="route('monsters.edit', monster.id)">
                                            Edit Monster
                                        </jet-dropdown-link>
                                        <jet-dropdown-link @click.native="delete_monster = monster" as="button">
                                            Delete Monster
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
        <jet-confirmation-modal :show="delete_monster" @close="delete_monster = false">
            <template #title>
                Delete Monster
            </template>

            <template #content>
                Are you sure you want to delete this monster?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="delete_monster = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteMonster">
                    Delete Monster
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

        <!-- clone -->
        <jet-dialog-modal type="form" :show="clone_monster" @close="closeClone" @submitted="cloneMonster">
            <template #header>
                Clone {{ clone_monster.display_name }}
            </template>

            <template #content>
                <!-- name -->
                <jet-label for="name" value="Name for Clone"/>
                <jet-input type="text" id="name" class="mt-1 w-full" v-model="clone_form.name" required/>
                <jet-input-error :message="clone_form.errors.name" class="mt-2"/>
            </template>

            <template #footerend>
                <jet-secondary-button @click.native="closeClone">
                    Cancel
                </jet-secondary-button>
                <jet-button class="ml-2" :class="{ 'opacity-25': clone_form.processing }" :disabled="clone_form.processing">
                    Clone {{ clone_monster.display_name }}
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
    import JetLabel from '@/Jetstream/Label'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import { Link } from '@inertiajs/inertia-vue3'
    import MonsterIcon from '@/Components/Icons/Monster'
    import HelpModal from '@/Components/HelpModal'

    export default {
        props: ['monsters'],

        components: {
            AppLayout,
            JetDropdown,
            JetDropdownLink,
            JetButton,
            JetSecondaryButton,
            JetDangerButton,
            JetConfirmationModal,
            JetDialogModal,
            JetLabel,
            JetInput,
            JetInputError,
            Link,
            MonsterIcon,
            HelpModal,
        },
        data() {
            return {
                search: null,
                delete_monster: false,
                clone_monster: false,
                clone_form: this.$inertia.form({
                    id: null,
                    name: null,
                }),
            }
        },
        computed: {
            filtered() {
                let result = this.monsters;
                if(this.search) {
                    let searching = this.search.toLowerCase();
                    result = result.filter(function(monster) {
                        if (monster.name.toLowerCase().includes(searching) || monster.type.toLowerCase().includes(searching) || monster.size.toLowerCase().includes(searching)) {
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
            ownerOrAdmin(monster) {
                if(this.$page.props.user.id == monster.user_id || this.$page.props.user.admin) {
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
            deleteMonster() {
                let form = this.$inertia.form({
                    id: this.delete_monster.id,
                });
                form.delete(route('monsters.destroy', form.id));
                this.delete_monster = false;
            },
            cloneMonster() {
                this.clone_form.id = this.clone_monster.id;
                this.clone_form.post(route('monsters.clone', this.clone_form.id));
                this.closeClone();
            },
            closeClone() {
                this.clone_form.name = null;
                this.clone_monster = false;
            }
        }
    }
</script>
