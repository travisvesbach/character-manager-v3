<template>
    <app-layout>
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

                <Link :href="route('characters.create')" class="ml-auto btn btn-primary" :as="'button'">
                        New Character
                </Link>
            </div>

            <div class="border-b-2 w-full border-color"></div>
            <div class="border-b-2 w-full border-color" v-for="character in characters">
                <div class="pl-1 py-1 flex items-center flex-1 hover-trigger">
                    <div class="inline-block ml-2 flex-1">
                        <div class="mb-1 flex items-center">
                            <div class="text-lg">{{ character.name }}</div>
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
                                    <jet-dropdown-link :href="route('characters.edit', character.id)">
                                        Edit Character
                                    </jet-dropdown-link>
                                    <jet-dropdown-link @click.native="confirmingDeleteCharacter = character" as="button">
                                        Delete Character
                                    </jet-dropdown-link>
                                </div>
                            </template>
                        </jet-dropdown>
                    </div>
                </div>
            </div>
        </div>

        <!-- delete confirmation -->
        <jet-confirmation-modal :show="confirmingDeleteCharacter" @close="confirmingDeleteCharacter = false">
            <template #title>
                Delete Character
            </template>

            <template #content>
                Are you sure you want to delete this character?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="confirmingDeleteCharacter = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteUser" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
            Link,
        },

        data() {
            return {
                confirmingDeleteCharacter: false,
                form: this.$inertia.form({
                    id: null,
                }),
            }
        },

        methods: {
            deleteUser() {
                this.form.id = this.confirmingDeleteCharacter.id;
                this.form.delete(route('characters.destroy', this.form.id));
                this.confirmingDeleteCharacter = false;
            }
        }
    }
</script>
