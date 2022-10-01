<template>

    <div v-if="!images?.data?.length"
        class="px-5 py-3 mt-2 mb-4 fs-5 fw-semibold text-center border text-muted">
        <span v-if="isFiltering">Sem resultados para sua filtragem!</span>
        <span v-else>Sem nada para listagem!</span>
    </div>

    <PaginationUi label="Paginação de usuários" :pages="images?.meta?.links" />

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import PaginationUi from '../../../../Components/PaginationUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { PaginationUi },

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