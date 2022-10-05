<template>

    <EmptyList :show="!pages?.data?.length" :is-filter="isFiltering" />

    <ListItem v-for="page in pages?.data" :key="page.id" :item="{
        cover: page.thumb_small,
        title: page.title,
        subtitle: page.description,
        coverStyle: null
    }">
        <template v-slot:badges>
            <BadgeUi class="mb-1 me-1" :text="`Autor: ${page?.author?.first_name}`"
                icon="user" />
        </template>

        <template v-slot:actions>
            <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.page.edit', {id:
            page.id})" />

            <ButtonConfirmationUi v-if="page.can?.delete" confirm-text="Excluir?"
                icon="trash" variant="danger" size="sm" class="ms-2" position="right"
                :data-action="$route('admin.page.destroy',
                {page: page.id})" confirm-with-request />
        </template>
    </ListItem>

    <PaginationUi label="Paginação" :pages="pages?.meta?.links" />

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import EmptyList from '../../../Components/EmptyList.vue';
import ListItem from '../../../Components/ListItem.vue';
import PaginationUi from '../../../Components/PaginationUi.vue';
import BadgeUi from '../../../Components/Ui/BadgeUi.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../Components/Ui/ButtonConfirmationUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, PaginationUi, EmptyList, BadgeUi, ButtonUi, ButtonConfirmationUi },
    props: {
        pages: { type: Object, default: [] },
        terms: { type: Object, default: {} },
        isFiltering: { type: Boolean, default: false },
    },
};

</script>