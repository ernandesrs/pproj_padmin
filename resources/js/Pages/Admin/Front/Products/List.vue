<template>
    <EmptyList :show="!products?.data?.length" :is-filter="isFiltering" />

    <div class="row justify-content-center">
        <ListItem v-for="product in products?.data" :key="product.id" :item="{
            cover: null,
            title: product.title,
            subtitle: '',
            coverStyle: 'rectangle'
        }">
            <template v-slot:badges>
                <BadgeUi class="mb-1 me-1 fw-light" text="kkkj" variant="info" />
            </template>

            <template v-slot:actions>
                <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.products.edit', {
                    product: product.id
                })" />

                <ButtonConfirmationUi confirm-text="Excluir?" icon="trash"
                    variant="danger" size="sm" class="ms-2" position="right" :data-action="$route('admin.products.destroy',
                    { product: product.id })" confirm-with-request
                    request-method="delete" />
            </template>
        </ListItem>
    </div>

    <PaginationUi label="Paginação de productos" :pages="products?.meta?.links" />

</template>

<script>

import EmptyList from '../../../../Components/EmptyList.vue';
import ListItem from './../../../../Components/ListItem.vue';
import PaginationUi from '../../../../Components/PaginationUi.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';
import Layout from './../../../../Layouts/Panel.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../../Components/Ui/ButtonConfirmationUi.vue';
import BadgeUi from '../../../../Components/Ui/BadgeUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { EmptyList, ListItem, PaginationUi, CardUi, ButtonUi, ButtonConfirmationUi, BadgeUi },

    props: {
        products: { type: Object, default: [] },
        isFiltering: { type: Boolean, default: false },
    },
}

</script>