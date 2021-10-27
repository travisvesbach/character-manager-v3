<template>
    <app-layout :title="dice_table.name">
        <template #header>
            {{ dice_table.name }}
        </template>

        <template #subheader>
            <div class="px-10">
                <jet-nav-link :href="route('dice_tables.index')" title="Return to dice tables">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Dice Tables
                </jet-nav-link>
            </div>
        </template>

        <div class="px-5 py-2 flex items-center lg:max-w-4xl mx-auto">
            <div class="hover-trigger flex items-center">
                <h2 class="text-4xl heading-color">{{ dice_table.name }}</h2>
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
                            <jet-dropdown-link :href="route('dice_tables.edit', dice_table.id)" v-if="ownerOrAdmin(dice_table)">
                                Edit Dice Table
                            </jet-dropdown-link>
                            <jet-dropdown-link @click.native="delete_dice_table = dice_table" as="button" v-if="ownerOrAdmin(dice_table)">
                                Delete Dice Table
                            </jet-dropdown-link>
                        </div>
                    </template>
                </jet-dropdown>
            </div>
            <jet-secondary-button class="ml-auto" size="sm" @click="rollTable(dice_table)">
                Roll
            </jet-secondary-button>
        </div>

        <grid-section class="lg:max-w-4xl mx-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-color">
                        <th class="p-1 text-left">Range</th>
                        <th class="py-1 px-4 text-left">Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-color hover-trigger" v-for="row in dice_table.rows">
                        <td class="py-2 px-1" v-html="formatRange(row.range)"/>
                        <td class="py-2 px-4" v-html="row.result"/>
                    </tr>
                </tbody>
            </table>
        </grid-section>

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
                    Delete Dice Table
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </app-layout>
</template>

<script>
    import GridSection from '@/Components/GridSection'

    import { DiceTable } from '@/Mixins/DiceTable'

    export default {
        props: ['dice_table'],
        components: {
            GridSection,
        },
        mixins: [DiceTable],
        methods: {
            formatRange(range) {
                if(range[0] && range[1] && range[1] != null) {
                    return range[0] + ' - ' + range[1];
                } else {
                    return range[0];
                }
            }
        }
    }
</script>

