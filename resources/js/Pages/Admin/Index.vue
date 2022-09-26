<template>

    <Head title='Dashboard' />

</template>
  
<script>

import Layout from './../../Layouts/Panel.vue';
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: { Head },
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,

    setup() {
        return {}
    },
}
</script>