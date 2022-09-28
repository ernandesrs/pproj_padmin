<template>

    <div class="bg-dark text-light">
    </div>

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';

export default {
    components: { },
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    props: {
        users: { type: Array, default: [] }
    },

    setup() {
        return {}
    },
}

</script>