<template>

    <div class="row">
        <div class="col-lg-8">
            <EmptyList :show="!menus?.data?.length" :is-filter="isFiltering" />

            <div class="row justify-content-center">
                <div v-for="menu in menus?.data" :key="menu.id"
                    class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="d-flex justify-content-center py-4 align-items-center">
                <p class="mb-0">
                    Escolha um para editar
                </p>
            </div>
        </div>
    </div>

    <PaginationUi label="Paginação de menus" :pages="menus?.meta?.links" />

</template>

<script>

import EmptyList from '../../../../Components/EmptyList.vue';
import PaginationUi from '../../../../Components/PaginationUi.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';
import Layout from './../../../../Layouts/Panel.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { EmptyList, PaginationUi, CardUi },

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