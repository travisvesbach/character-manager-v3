<template>
    <app-layout title="dice_tables">
        <template #header>
            Dice Tables
        </template>

        <div class="w-full md:w-3/4 xl:w-1/2 mx-auto pb-10 sm:px-6 lg:px-8 m-2">

            <div class="flex mb-1 mx-2 items-end">
                <div class="flex items-end">
                    <dice-icon class="h-8 w-8"/>
                    <span class="ml-1">{{ dice_tables.length }} {{ dice_tables.length == 1 ? 'dice table' : 'dice tables' }}</span>
                </div>

                <jet-input class="ml-auto mr-2 p-1" type="text" v-model="search" placeholder="search"/>

                <Link :href="route('dice_tables.create')" class="btn btn-primary" :as="'button'">
                        New Dice Table
                </Link>
                <help-modal class="ml-2">
                    <template #header>
                        Dice Tables
                    </template>
                    <template #content>
                        <p class="mb-4">
                            Dice tables are used for returning random results from a predefined table.
                        </p>
                        <p class="mb-4">
                            Dice tables can be marked as Public or Private.  Public dice tables are available for everyone to use, but only the dice table creator or an admin can edit them.  Private dice tables are only available to the dice table's creator.  If adding a general dice table from a sourcebook, it should be added as Public in order so that we don't end up with multiple copies of the same dice tables.  Always check to make sure the dice table you're going to create doesn't already exist.  An admin will go through on occasion and remove duplicates.
                        </p>
                        <p class="mb-4">
                            Dice tables can be added to creatures as a resource.  For example, a wild magic sorcerer may want to add the wild magic table to their character page so they don't have to return to the dice tables page all the time.  Note that when a dice table is deleted, creature resources that reference that dice table will also be removed.
                        </p>
                    </template>
                </help-modal>
            </div>

            <div class="border-b-2 w-full border-color"></div>
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-color">
                        <th class="p-1 text-left">Name</th>
                        <th class="p-1 text-left">Dice Size</th>
                        <th class="p-1 text-left">Visibility</th>
                        <th class="p-1 text-left">Owner</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-color hover-trigger" v-for="dice_table in filtered">
                        <td class="py-2 px-1">
                            <Link :href="dice_table.path" class="text-lg link-color" v-html="highlight(dice_table.name)"/>
                        </td>
                        <td class="py-2 px-1" v-html="highlight(dice_table.dice_size)"/>
                        <td class="py-2 px-1">
                            {{ dice_table.public ? 'public' : 'private' }}
                        </td>
                        <td class="py-2 px-1">
                            {{ dice_table.user.name }}
                        </td>
                        <td class="py-2 px-1">
                            <jet-secondary-button size="sm" @click="rollTable(dice_table)">
                                Roll
                            </jet-secondary-button>
                        </td>
                        <td class="py-2 px-1" v-if="ownerOrAdmin(dice_table)">
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
                                        <jet-dropdown-link :href="route('dice_tables.edit', dice_table.id)">
                                            Edit Dice Table
                                        </jet-dropdown-link>
                                        <jet-dropdown-link @click.native="delete_dice_table = dice_table" as="button">
                                            Delete Dice Table
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
        <jet-confirmation-modal :show="delete_dice_table" @close="delete_dice_table = false">
            <template #title>
                Delete Dice Table
            </template>

            <template #content>
                Are you sure you want to delete this dice table?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="delete_dice_table = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteDiceTable">
                    Delete
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

    </app-layout>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'
    import DiceIcon from '@/Components/Icons/Dice'
    import HelpModal from '@/Components/HelpModal'

    import { DiceTable } from '@/Mixins/DiceTable'

    export default {
        props: ['dice_tables'],

        components: {
            Link,
            DiceIcon,
            HelpModal,
        },
        mixins: [DiceTable],
        data() {
            return {
                search: null,
            }
        },
        computed: {
            filtered() {
                let result = this.dice_tables;
                if(this.search) {
                    let searching = this.search.toLowerCase();
                    result = result.filter(function(dice_table) {
                        if (dice_table.name.toLowerCase().includes(searching)) {
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
            highlight(content) {
                if(!this.search) {
                    return content;
                }
                return content.replace(new RegExp(this.search, "gi"), match => {
                    return '<span class="highlight">' + match + '</span>';
                });
            },
        }
    }
</script>
