<template>
    <h6 class="dropdown-header" v-html="text"></h6>
</template>

<script>
export default {
    props: {
        text: { type: String, default: null }
    }
};
</script>