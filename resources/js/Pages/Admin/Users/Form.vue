<template>

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';

export default {
    components: {},
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    props: {
        user: { type: Object, default: null },
    },

    setup() {
        return {}
    },
}

</script>