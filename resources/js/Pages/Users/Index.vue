<template>
    <app-layout>
        <template #header>
            Users
        </template>

        <div class="w-full md:w-3/4 xl:w-1/2 mx-auto pb-10 sm:px-6 lg:px-8 m-2">

            <div class="flex mb-1 mx-2 text-color items-end">
                <div class="flex items-center">
                    <svg class="h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="ml-1">{{ users.length }} {{ users.length == 1 ? 'user' : 'users' }}</span>
                </div>

                <jet-button class="ml-auto">
                    <Link :href="route('users.create')">New User</Link>
                </jet-button>
            </div>

            <div class="border-b-2 border-color w-full"></div>
            <div class="border-b-2 border-color w-full" v-for="user in users">
                <div class="pl-1 py-1 flex items-center flex-1 hover-trigger">
                    <div class="inline-block ml-2 flex-1">
                        <div class="mb-1 flex items-center">
                            <div class="text-lg">{{ user.name }}</div>
                            <badge :value="'admin'" v-if="user.admin"/>
                        </div>
                        <a :href="'mailto:' + user.email" class="text-sm link-color">{{ user.email }}</a>
                    </div>
                    <div class="inline-block">
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
                                    <jet-dropdown-link :href="route('users.edit', {id: user.id})">
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
                    </div>
                </div>
            </div>
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
            Link,
        },

        data() {
            return {
                confirmingDeleteUser: false,
                form: this.$inertia.form({
                    id: null,
                }),
            }
        },

        methods: {
            deleteUser() {
                this.form.id = this.confirmingDeleteUser.id;
                this.form.delete('/users/' + this.form.id);
                this.confirmingDeleteUser = false;
            }
        }
    }
</script>