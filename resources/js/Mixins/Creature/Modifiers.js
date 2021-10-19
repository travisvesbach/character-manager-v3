export const CreatureModifiers = {
    data() {
        return {
            form: this.$inertia.form({}),
        };
    },
    methods: {
        setForm(modifier = null) {
            if(modifier) {
                this.form = this.$inertia.form({
                    id: modifier.id,
                    name: modifier.name,
                    creature_id: modifier.creature_id,
                    creature_type: modifier.creature_type,
                    ability: modifier.ability,
                    ability_dice: modifier.ability_dice,
                    save: modifier.save,
                    save_dice: modifier.save_dice,
                    attack: modifier.attack,
                    attack_dice: modifier.attack_dice,
                    critical_range: modifier.critical_range,
                    critical_range_start: modifier.critical_range_start,
                    damage: modifier.damage,
                    damage_as: modifier.damage_as,
                    damage_dc: modifier.damage_dc,
                    damage_save: modifier.damage_save,
                    damage_dice: modifier.damage_dice,
                    notes: modifier.notes,
                    enabled: modifier.enabled,
                    no_alert: false,
                    editing: true,
                });
            } else {
                this.form = this.$inertia.form({
                    id: null,
                    name: null,
                    creature_id: this.creature.id,
                    creature_type: 'App\\Models\\'+this.getModel(),
                    ability: false,
                    ability_dice: [{
                        count: 0,
                        size: 0,
                        modifier: 0,
                    }],
                    save: false,
                    save_dice: [{
                        count: 0,
                        size: 0,
                        modifier: 0,
                    }],
                    attack: false,
                    attack_dice: [{
                        count: 0,
                        size: 0,
                        modifier: 0,
                    }],
                    critical_range: false,
                    critical_range_start: null,
                    damage: false,
                    damage_as: null,
                    damage_dc: null,
                    damage_save: null,
                    damage_dice: [{
                        count: 0,
                        size: 0,
                        modifier: 0,
                        type: null,
                    }],
                    notes: null,
                    enabled: false,
                    no_alert: false,
                });
            }
        },
        saveModifier(no_alert = false) {
            if(this.form.ability == false && this.form.save == false && this.form.attack == false && this.form.critical_range == false && this.form.damage == false) {
                this.form.errors.types = 'required';
                return;
            } else {
                this.form.errors.types = null;
            }

            if(this.form.editing) {
                this.form.patch(route('modifiers.update', this.form.id), {
                    onSuccess: (response) => {
                        this.closeModal();
                    }
                });
            } else {
                this.form.post(route('modifiers.store'), {
                    onSuccess: (response) => {
                        this.closeModal();
                    }
                });
            }
        },
        toggleEnabled(modifier) {
            this.setForm(modifier);
            this.form.enabled = modifier.enabled;
            this.form.no_alert = true;
            this.saveModifier();
        },
    }
}
