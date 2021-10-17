<template>
    <div>
        <jet-secondary-button size="sm" @click="add_monsters = true">
            Add Monsters
        </jet-secondary-button>

        <!-- add monsters -->
        <jet-dialog-modal :show="add_monsters" @close="add_monsters = false">
            <template #header>
                Add Monsters to Encounter
            </template>

            <template #content>
                <div class="text-right">
                    <jet-input class="p-1" type="text" v-model="search" placeholder="search"/>
                </div>
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
                        <tr class="border-b-2 border-color" v-for="monster in filtered">
                            <td class="py-2 px-1" v-html="highlight(monster.name)">
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
                            <td class="py-2 px-1">
                                <jet-button @click="addMonster(monster)" size="sm">
                                    Add
                                </jet-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>

            <template #footerend>
                <jet-button @click.native="add_monsters = false">
                    Done
                </jet-button>
            </template>
        </jet-dialog-modal>
    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetInput from '@/Jetstream/Input'

    export default {
        props: ['encounter', 'monsters'],

        components: {
            JetButton,
            JetSecondaryButton,
            JetDialogModal,
            JetInput,
        },
        data() {
            return {
                search: null,
                add_monsters: false,
            }
        },
        computed: {
            filtered() {
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
            highlight(content) {
                if(!this.search) {
                    return content;
                }
                return content.replace(new RegExp(this.search, "gi"), match => {
                    return '<span class="highlight">' + match + '</span>';
                });
            },
            addMonster(monster) {
                let form = this.$inertia.form({
                    monster_id: monster.id,
                });
                form.post(route('encounter_monsters.store', this.encounter.id));
            }
        }
    }
</script>
