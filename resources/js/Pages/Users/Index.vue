<template>
    <app-layout title="Users">
        <template #header>
            Users
        </template>

        <div class="w-full md:w-3/4 xl:w-1/2 mx-auto pb-10 sm:px-6 lg:px-8 m-2">
            <div class="flex mb-1 mx-2 items-end">
                <div class="flex items-end">
                    <svg class="h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="ml-1">{{ users.length }} {{ users.length == 1 ? 'user' : 'users' }}</span>
                </div>

                <jet-input class="ml-auto mr-2 p-1" type="text" v-model="search" placeholder="search"/>

                <Link :href="route('users.create')" class="btn btn-primary" :as="'button'">
                        New User
                </Link>
            </div>

            <div class="border-b-2 w-full border-color"></div>



            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-color">
                        <th class="p-1 text-left">Name</th>
                        <th class="p-1 text-left">Email</th>
                        <th class="p-1 text-left">Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-color hover-trigger" v-for="user in filtered">
                        <td class="py-2 px-1" v-html="highlight(user.name)"/>
                        <td class="py-2 px-1">
                            <a :href="'mailto:' + user.email" class="text-sm link-color" v-html="highlight(user.email)"/>
                        </td>
                        <td class="py-2 px-1" v-html="user.admin ? 'Admin' : '&#8212'"/>
                        <td class="py-2 px-1">
                            <!-- dropdown -->
                            <jet-dropdown align="right" width="48" class="hover-target">
                                <template #trigger>
                                    <button class="flex link link-color">
                                        <svg class="fill-current h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <div v-if="user.id != $page.props.user.id">
                                        <jet-dropdown-link :href="route('users.edit', user.id)">
                                            Edit User
                                        </jet-dropdown-link>
                                        <jet-dropdown-link @click.native="confirmingDeleteUser = user" as="button">
                                            Delete User
                                        </jet-dropdown-link>
                                    </div>

                                    <jet-dropdown-link :href="route('profile.show')" v-if="user.id == $page.props.user.id">
                                        My Profile
                                    </jet-dropdown-link>
                                </template>
                            </jet-dropdown>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- delete confirmation -->
        <jet-confirmation-modal :show="confirmingDeleteUser" @close="confirmingDeleteUser = false">
            <template #title>
                Delete User
            </template>

            <template #content>
                Are you sure you want to delete this user? All of this user's characters, monsters (including public), and encounters will be deleted as well.
            </template>

            <template #footer>
                <jet-secondary-button @click.native="confirmingDeleteUser = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteUser" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete User
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
        props: ['users'],

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
                confirmingDeleteUser: false,
                form: this.$inertia.form({
                    id: null,
                }),
                search: null,
            }
        },
        computed: {
            filtered() {
                let result = this.users;
                if(this.search) {
                    let searching = this.search.toLowerCase();
                    result = result.filter(function(user) {
                        if(user.name.toLowerCase().includes(searching) || user.email.toLowerCase().includes(searching)) {
                            return true;
                        } else {
                            return false;
                        }
                    });
                }
                return result;
            }
        },
        methods: {
            highlight(content) {
                if(!this.search) {
                    return content;
                }
                return content.replace(new RegExp(this.search, "gi"), match => {
                    return '<span class="highlight">' + match + '</span>';
                });
            },
            deleteUser() {
                this.form.id = this.confirmingDeleteUser.id;
                this.form.delete(route('users.destroy', this.form.id));
                this.confirmingDeleteUser = false;
            }
        }
    }
</script>
