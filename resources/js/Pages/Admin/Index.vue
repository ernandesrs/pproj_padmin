<template>

    <Head title='Dashboard' />

    <ButtonUi text="Opa" variant="primary" href="https://www.google.com"
        target="_blank" />

</template>

<script>

import Layout from './../../Layouts/Panel.vue';
import { Head } from '@inertiajs/inertia-vue3';
import ButtonUi from '../../components/Ui/ButtonUi.vue';

export default {
    components: { Head, ButtonUi },
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,

    setup() {
        return {}
    },
}
</script>