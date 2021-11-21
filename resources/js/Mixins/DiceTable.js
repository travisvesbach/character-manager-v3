import AppLayout from '@/Layouts/AppLayout'
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetInput from '@/Jetstream/Input'
import JetDropdown from '@/Jetstream/Dropdown'
import JetDropdownLink from '@/Jetstream/DropdownLink'
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetLabel from '@/Jetstream/Label'
import JetInputError from '@/Jetstream/InputError'

import { Flash } from '@/Mixins/Flash'
import { DiceTableRoll } from '@/Mixins/DiceTableRoll'

export const DiceTable = {
    components: {
        AppLayout,
        JetNavLink,
        JetInput,
        JetDropdown,
        JetDropdownLink,
        JetButton,
        JetSecondaryButton,
        JetDangerButton,
        JetConfirmationModal,
    },
    mixins: [Flash, DiceTableRoll],
    data() {
        return {
            delete_dice_table: false,
        }
    },
    methods: {
        ownerOrAdmin(dice_table) {
            if(this.$page.props.user.id == dice_table.user_id || this.$page.props.user.admin) {
                return true;
            }
            return false;
        },
        deleteDiceTable() {
            let form = this.$inertia.form({
                id: this.delete_dice_table.id,
            });
            form.delete(route('dice_tables.destroy', form.id));
            this.delete_dice_table = false;
        },
    }
}
