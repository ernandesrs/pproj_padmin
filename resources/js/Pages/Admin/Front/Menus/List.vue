<template>

    <EmptyList :show="!menus?.data?.length" :is-filter="isFiltering" />

    <div class="row justify-content-center">
        <div v-for="menu in menus?.data" :key="menu.id"
            class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">

        </div>
    </div>

    <PaginationUi label="Paginação de menus" :pages="menus?.meta?.links" />

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: {},

    props: {
        menus: { type: Object, default: [] },
        terms: { type: Object, default: {} },
        isFiltering: { type: Boolean, default: false },
    },

    data() {
        return {
        };
    },

    methods: {
    },

    computed: {
    }
}

</script>