<template>
    <EmptyList :show="totalItems == 0" :is-filter="isFiltering" />

    <slot />

    <PaginationUi v-if="paginationPages.length" :pages="paginationPages" :label="paginationLabel" :url-params="paginationUrlParams" />
</template>

<script>

import EmptyList from './EmptyList.vue';
import PaginationUi from './PaginationUi.vue';

export default {
    components: { EmptyList, PaginationUi },
    props: {
        totalItems: { type: Number, default: 0 },
        isFiltering: { type: Boolean, default: false },

        paginationPages: { type: Array, default: [] },
        paginationLabel: { type: String, default: null },
        paginationUrlParams: { type: String, default: null }
    }
}

</script>