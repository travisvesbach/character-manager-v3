export const CreatureResources = {
    data() {
        return {
            form: this.$inertia.form({}),
        }
    },
    methods: {
        setForm(resource = null) {
            if(resource) {
                this.form = this.$inertia.form({
                    id: resource.id,
                    name: resource.name,
                    creature_id: resource.creature_id,
                    creature_type: resource.creature_type,
                    type: resource.type,
                    total: resource.total,
                    counter_type: resource.counter_type,
                    slots: resource.slots,
                    current: resource.current,
                    recover: resource.recover,
                    dice: JSON.parse(JSON.stringify(resource.dice)),
                    no_alert: false,
                    editing: true,
                });
            } else {
                this.form = this.$inertia.form({
                    id: null,
                    name: null,
                    creature_id: this.creature.id,
                    creature_type: 'App\\Models\\'+this.getModel(),
                    type: null,
                    total: null,
                    counter_type: 'slots',
                    slots: null,
                    current: null,
                    recover: '',
                    dice: [{
                        count: null,
                        size: null,
                        modifier: null,
                    }],
                    no_alert: false,
                });
            }
        },
        saveResource() {
            if(this.form.editing) {
                this.form.patch(route('resources.update', this.form.id), {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.show_modal = false;
                    }
                });
            } else {
                this.form.post(route('resources.store'), {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.show_modal = false;
                    }
                });
            }
        },
        updateSlot(resource, index) {
            resource.slots[index] = !resource.slots[index];
            this.setForm(resource);
            this.form.no_alert = true;
            this.saveResource();
        },
        rollDice(resource) {
            let total = 0;
            let message = this.creature.display_name + ':<br>';
            message += resource.name + ':<br>';
            let loop_total = 0;
            for(let i=0;i<resource.dice.length;i++) {
                loop_total = 0;
                if(resource.dice[i].size > 0) {
                    message += '[';
                    for(let j=0;j<resource.dice[i].count;j++) {
                        let result = dice.roll(resource.dice[i].size);
                        loop_total += result;
                        message += result + (j < resource.dice[i].count - 1 ? ', ' : '');
                    }
                    message += '] ';
                }
                loop_total += getNumber(resource.dice[i].modifier);
                message += (resource.dice[i].modifier ? (resource.dice[i].size > 0 ? '+ ' : '') + resource.dice[i].modifier : '') + ' = ' + loop_total;

                total += loop_total;
                message += '<br>'
            }
            if(total != loop_total) {
                message += 'Total: ' + total;
            }
            this.flash(message, 'primary');
        }
    }
}
