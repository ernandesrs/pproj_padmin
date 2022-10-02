<template>

    <EmptyList :show="!images?.length" :is-filter="isFiltering" />

    <PaginationUi label="Paginação de imagens" :pages="images?.meta?.links" />

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import PaginationUi from '../../../../Components/PaginationUi.vue';
import EmptyList from '../../../../Components/EmptyList.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { PaginationUi, EmptyList },

    data() {
        return {
        };
    },

    props: {
        images: { type: Object, default: [] },
        terms: { type: Object, default: {} },
        isFiltering: { type: Boolean, default: false },
    },

    methods: {
    },

    computed: {
    }
}

</script>