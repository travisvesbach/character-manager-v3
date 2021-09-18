<template>
    <div>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                accordion_items: [],
                open: null
            }
        },
        provide() {
            return {
                addItem: this.addItem,
                removeItem: this.removeItem,
                setOpen: this.setOpen
            }
        },
        methods: {
            addItem(item) {
                this.accordion_items.push(item);
            },
            removeItem(item) {
                if (this.open == item) {
                    this.open = null;
                }
                let index = this.accordion_items.findIndex(i => i._uid == item._uid);
                this.accordion_items.splice(index, 1);
            },
            setOpen(item, isOpen) {
                for(let i=0;i<this.accordion_items.length;i++) {
                    if(isOpen == true && this.accordion_items[i].id != item.id) {
                        this.accordion_items[i].toggle(false);
                    }
                }
                if(isOpen == false) {
                    this.open == null;
                } else {
                    this.open = item;
                }
            }
        }
    };
</script>
