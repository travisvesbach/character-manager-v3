<template>
    <app-layout title="Dashboard">
        <template #header>Dashboard</template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-8">
                    <grid-section class="sm:rounded-lg overflow-hidden" title="Recent Characters" icon="Character">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-color">
                                    <th class="p-1 text-left">Name</th>
                                    <th class="p-1 text-left">Class</th>
                                    <th class="p-1 text-left">Race</th>
                                    <th class="p-1 text-left">Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b-2 border-color hover-trigger" v-for="character in characters">
                                    <td class="py-2 px-1">
                                        <Link :href="character.path" class="text-lg link-color" v-html="character.name"/>
                                    </td>
                                    <td class="py-2 px-1" v-html="character.class"/>
                                    <td class="py-2 px-1" v-html="character.race"/>
                                    <td class="py-2 px-1">
                                        {{ character.level }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </grid-section>

                    <grid-section class="sm:rounded-lg overflow-hidden" title="Recent Encounters" icon="Encounter">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-color">
                                    <th class="p-1 text-left">Name</th>
                                    <th class="p-1 text-left">Monsters</th>
                                    <th class="p-1 text-left">Experience</th>
                                    <th class="p-1 text-left">Difficulty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b-2 border-color hover-trigger" v-for="encounter in encounters">
                                    <td class="py-2 px-1">
                                        <Link :href="encounter.path" class="text-lg link-color" v-html="encounter.name"/>
                                    </td>
                                    <td class="py-2 px-1" v-html="encounter.monsters_count"/>
                                    <td class="py-2 px-1" v-html="encounter.experience"/>
                                    <td class="py-2 px-1" v-html="encounter.difficulty"/>
                                </tr>
                            </tbody>
                        </table>
                    </grid-section>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import GridSection from '@/Components/GridSection'
    import { Link } from '@inertiajs/inertia-vue3'

    export default defineComponent({
        components: {
            AppLayout,
            GridSection,
            Link,
        },
        props: ['characters', 'monsters', 'encounters'],
        data() {
            return {

            }
        },
        computed: {

        },
        methods: {

        }
    })
</script>
