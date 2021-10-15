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

                <Link :href="route('monsters.create')" class="ml-auto btn btn-primary" :as="'button'">
                        New Monster
                </Link>
            </div>

            <div class="border-b-2 w-full border-color"></div>
            <div class="border-b-2 w-full border-color" v-for="monster in monsters">
                <div class="pl-1 py-1 flex items-center flex-1 hover-trigger">
                    <div class="inline-block ml-2 flex-1">
                        <div class="mb-1 flex items-center">
                            <Link :href="monster.path" class="text-lg link-color">
                                {{ monster.name }}
                            </Link>
                        </div>
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
                                <div>
                                    <jet-dropdown-link :href="route('monsters.edit', monster.id)">
                                        Edit Monster
                                    </jet-dropdown-link>
                                    <jet-dropdown-link @click.native="confim_delete_monster = monster" as="button">
                                        Delete Monster
                                    </jet-dropdown-link>
                                </div>
                            </template>
                        </jet-dropdown>
                    </div>
                </div>
            </div>
        </div>

        <!-- delete confirmation -->
        <jet-confirmation-modal :show="confim_delete_monster" @close="confim_delete_monster = false">
            <template #title>
                Delete Monster
            </template>

            <template #content>
                Are you sure you want to delete this monster?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="confim_delete_monster = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deletemonster" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
            Link,
        },

        data() {
            return {
                confim_delete_monster: false,
                form: this.$inertia.form({
                    id: null,
                }),
            }
        },

        methods: {
            deletemonster() {
                this.form.id = this.confim_delete_monster.id;
                this.form.delete(route('monsters.destroy', this.form.id));
                this.confim_delete_monster = false;
            }
        }
    }
</script>
