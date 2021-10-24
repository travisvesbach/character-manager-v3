<template>
    <input type="checkbox" :value="value" v-model="proxyChecked"
           class="form-input" :class="checked == 'hidden' ? 'invisible' : ''">
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    emits: ['update:checked'],

    props: {
        checked: {
            type: [Array, Boolean, Number, String],
            default: false,
        },
        value: {
            default: null,
        },
    },

    computed: {
        proxyChecked: {
            get() {
                return this.checked && this.checked != 'hidden' ? true : false;
            },

            set(val) {
                this.$emit("update:checked", val);
            },
        },
    },
})
</script>
