<template>
    <button>
        {{ slot ? '\u26AB' : "\u26AA" }}
    </button>
</template>

<script>
    export default {
        props: ['slot'],
    }
</script>
