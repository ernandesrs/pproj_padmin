<template>

    <Head :title="(user??null)?'Editar usuário':'Novo usuário'" />

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: { Head },
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