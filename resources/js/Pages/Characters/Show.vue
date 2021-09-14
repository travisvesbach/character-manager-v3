<template>
    <app-layout>
        <template #header>
            <div class="hover-trigger flex items-center">
                {{ character.name }}
                <jet-dropdown align="left" width="48" class="hover-target ml-1">
                    <template #trigger>
                        <button class="flex link link-color">
                            <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
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
            <span class="ml-1 text-xs text-color ">
                Level {{ character.level }} {{ character.race }} {{ character.class }}
            </span>
        </template>


        <template #subheader>
            <div class="flex items-center px-10">
                <jet-nav-link :href="creature.path" :active="creature.id == character.id" preserve-state v-for="creature in characters" :title="'Level ' + creature.level + ' ' +  creature.race + ' ' +  creature.class">
                    {{ creature.name }}
                </jet-nav-link>
            </div>
        </template>

        <character-nav :creatures="characters"/>

        <heading v-model:creature="character"/>

        <stats v-model:creature="character"/>


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
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import Heading from '@/Components/Creature/Heading'
    import Stats from '@/Components/Creature/Stats'

    export default {
        props: ['character', 'characters'],

        components: {
            AppLayout,
            JetDropdown,
            JetDropdownLink,
            JetButton,
            JetSecondaryButton,
            JetDangerButton,
            JetConfirmationModal,
            JetNavLink,
            Heading,
            Stats
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
            deleteCharacter() {
                this.form.id = this.confirmingDeleteCharacter.id;
                this.form.delete(route('characters.destroy', this.form.id));
                this.confirmingDeleteCharacter = false;
            }
        }
    }
</script>
