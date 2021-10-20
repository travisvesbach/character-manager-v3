<template>
    <div class="p-1">
        <div>
            <div class="flex items-baseline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 drag-handle cursor-move" fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Drag and drop to sort">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <Link :href="creature.path" class="text-2xl font-bold" title="Show">
                    {{ creature.display_name }}
                </Link>
                <span class="text-xs ml-2" :title="creature.ac_source">AC: {{ creature.ac }}</span>
                <button class="ml-auto btn-text" @click="delete_creature = true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex items-baseline">
                <jet-secondary-button @click="roll('Initiative', creature.initiative)" size="xs" :disabled="disabled">
                    Initiative
                </jet-secondary-button>
                <span class="mx-2">Speed: {{ creature.speed }}</span>
                <div class="ml-auto">
                    <span :title="'Max HP: ' + creature.hp_max + (creature.hp_temp > 0 ? ' Temp HP: ' + creature.hp_temp : '')">
                        {{ creature.hp_current + creature.hp_temp }} HP
                        <span v-if="creature.hp_temp > 0">(T)</span>
                    </span>
                    <jet-input type="number" class="w-10 text-sm p-1 ml-1" @keyup.enter="adjustHp()" v-model.number="hp_calculator"/>
                </div>
            </div>
        </div>

        <!-- delete confirmation -->
        <jet-confirmation-modal :show="delete_creature" @close="delete_creature = false">
            <template #title>
                Delete {{ creature.display_name }}
            </template>

            <template #content>
                Are you sure you want to delete {{ creature.display_name }}?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="delete_creature = false">
                    Cancel
                </jet-secondary-button>
                <jet-danger-button class="ml-2" @click.native="deleteCreature">
                    Delete {{ creature.display_name }}
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </div>
</template>

<script>
    import { CreatureHeading } from '@/Mixins/Creature/Heading';

    export default {
        mixins: [CreatureHeading],
        methods: {
            // modified from creature/heading.vue so that when adding extra hp, it is converted to hp_temp
            adjustHp() {
                let calc_amount = this.hp_calculator;
                let update = false;

                if(Number.isInteger(calc_amount) && calc_amount > 0) {
                    if(Number.isInteger(this.creature.hp_current) && Number.isInteger(calc_amount)) {
                        this.creature.hp_current += calc_amount;
                        if(this.creature.hp_current > this.creature.hp_max) {
                            calc_amount = this.creature.hp_current - this.creature.hp_max;
                            this.creature.hp_current = this.creature.hp_max;
                        } else {
                            calc_amount = 0;
                        }
                    }
                    if(calc_amount > 0) {
                        this.creature.hp_temp += calc_amount;
                    }
                    update = true;
                } else if(Number.isInteger(calc_amount) && calc_amount < 0) {
                    if(Number.isInteger(this.creature.hp_temp) && this.creature.hp_temp != 0 && Number.isInteger(this.hp_calculator)) {
                        this.creature.hp_temp += calc_amount;
                        if(this.creature.hp_temp < 0) {
                            calc_amount = this.creature.hp_temp;
                            this.creature.hp_temp = 0;
                        } else {
                            calc_amount = 0;
                        }
                    }
                    if(Number.isInteger(this.creature.hp_current) && Number.isInteger(calc_amount)) {
                        this.creature.hp_current += calc_amount;
                    }
                    update = true;
                }
                if(update) {
                    this.updateCreature(true);
                }
                this.hp_calculator = null;
            },
            deleteCreature() {
                let form = this.$inertia.form({
                    id: this.creature.id,
                });
                form.delete(this.getRoute('destroy'), {
                    preserveState: true,
                    preserveScroll: true,
                });
                this.delete_creature = false;
            }
        }
    }
</script>
