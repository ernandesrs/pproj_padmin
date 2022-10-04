<template>

    <div class="row justify-content-center">
        <div class="col-12">
            OPA
        </div>
    </div>

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: {},
    props: {
        page: { type: Object, default: [] },
        terms: { type: Object, default: {} },
    },
};

</script>