<template>
    <div class="inline-block cursor-pointer" @click="roll">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            size: {
                default: 20
            },
            modifier: {
                default: 0
            },
            message: {
                deafult: ''
            },
        },
        methods: {
            roll() {
                let result =  (Math.floor(Math.random() * this.size) + 1);
                let output = this.message + '[' + result + ']' + (this.modifier ? ' + ' + this.modifier : '') + ' = ' + (result + this.modifier);
                console.log(output);
                this.$page.props.flash.message = output;
                this.$page.props.flash.status = 'primary';
            }
        }
    }
</script>
