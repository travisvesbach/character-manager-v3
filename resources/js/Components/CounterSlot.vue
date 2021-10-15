<template>
    <button class="btn-text">
        {{ slot ? '\u26AB' : "\u26AA" }}
    </button>
</template>

<script>
    export default {
        props: ['slot'],
    }
</script>
