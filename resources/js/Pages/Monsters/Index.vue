<template>
    <app-layout title="monsters">
        <template #header>
            Monsters
        </template>

        <div class="w-full md:w-3/4 xl:w-1/2 mx-auto pb-10 sm:px-6 lg:px-8 m-2">

            <div class="flex mb-1 mx-2 items-end">
                <div class="flex items-center">
                    <svg class="h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="ml-1">{{ monsters.length }} {{ monsters.length == 1 ? 'monster' : 'monsters' }}</span>
                </div>

                <jet-input class="ml-auto mr-2 p-1" type="text" v-model="search" placeholder="search"/>

                <Link :href="route('monsters.create')" class="btn btn-primary" :as="'button'">
                        New Monster
                </Link>
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
                    <tr class="border-b-2 border-color hover-trigger" v-for="monster in filteredData">
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
                                        <svg class="fill-current h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <div>
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
    import { Link } from '@inertiajs/inertia-vue3'

    export default {
        props: ['monsters'],

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
        },
        data() {
            return {
                search: null,
                delete_monster: false,
            }
        },
        computed: {
            filteredData() {
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
        }
    }
</script>
