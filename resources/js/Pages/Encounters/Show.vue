<template>
    <app-layout :title="encounter.name">
        <template #header>
            {{ encounter.name }}
        </template>

        <template #subheader>
            <div class="flex items-center px-10">
                <jet-nav-link :href="item.path" :active="encounter.id == item.id" preserve-state v-for="item in encounters">
                    {{ item.name }}
                </jet-nav-link>
            </div>
        </template>

        <div class="px-5 py-2 flex items-center">
            <div class="hover-trigger flex items-center">
                <h2 class="text-4xl heading-color">{{ encounter.name }}</h2>
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
                            <jet-dropdown-link :href="route('encounters.edit', encounter.id)" v-if="ownerOrAdmin">
                                Edit Encounter
                            </jet-dropdown-link>
                            <jet-dropdown-link @click.native="delete_encounter = true" as="button" v-if="ownerOrAdmin">
                                Delete Encounter
                            </jet-dropdown-link>
                        </div>
                    </template>
                </jet-dropdown>
            </div>
            <add-monsters class="ml-auto" :encounter="encounter" :monsters="monsters"/>
        </div>

        <div class="grid md:grid-cols-4">

            <grid-section class="col-span-3">
                <div class="grid md:grid-cols-2 xl:grid-cols-3">
                    <div class="col-span-1" v-for="monster in encounter.monsters">
                        <simple-show :creature="monster" type="Encounter Monster"/>
                    </div>
                </div>

            </grid-section>

            <div class="col-span-1">
                <dice />
                <grid-section title="Notepad">
                    <textarea id="notes" class="w-full h-full p-0 form-input bg-transparent dark:bg-transparent" style="min-height: 12rem;" v-model="encounter.notes" @blur="updateEncounter(true)"/>
                </grid-section>
            </div>

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
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import JetInput from '@/Jetstream/Input'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetLabel from '@/Jetstream/Label'
    import JetInputError from '@/Jetstream/InputError'
    import GridSection from '@/Components/GridSection';
    import Dice from '@/Components/Dice';
    import AddMonsters from '@/Components/Encounter/AddMonsters';
    import SimpleShow from '@/Components/Creature/SimpleShow';

    export default {
        props: ['encounter', 'encounters', 'monsters'],
        components: {
            AppLayout,
            JetNavLink,
            JetInput,
            JetDropdown,
            JetDropdownLink,
            JetButton,
            JetSecondaryButton,
            JetDangerButton,
            JetDialogModal,
            JetConfirmationModal,
            GridSection,
            Dice,
            AddMonsters,
            SimpleShow,
        },
        data() {
            return {
                delete_encounter: false,
            }
        },
        methods: {
            ownerOrAdmin() {
                if(this.$page.props.user.id == this.encounter.user_id || this.$page.props.user.admin) {
                    return true;
                }
                return false;
            },
            updateEncounter(no_alert = false) {
                let form = this.$inertia.form({
                    id: this.encounter.id,
                    name: this.encounter.name,
                    notes: this.encounter.notes,
                    no_alert: no_alert,
                });
                form.patch(route('encounters.update', form.id));
            },
            deleteEncounter() {
                let form = this.$inertia.form({
                    id: this.encounter.id,
                });
                form.delete(route('encounters.destroy', form.id));
            }
        }
    }
</script>

