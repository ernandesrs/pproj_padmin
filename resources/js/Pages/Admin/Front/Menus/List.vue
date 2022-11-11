<template>
    <EmptyList :show="!menus?.data?.length" :is-filter="isFiltering" />

    <div class="row justify-content-center">
        <ListItem v-for="menu in menus?.data" :key="menu.id" :item="{
            cover: null,
            title: menu.name,
            subtitle: '',
            coverStyle: 'rectangle'
        }">
            <template v-slot:badges>
                <BadgeUi class="mb-1 me-1 fw-light"
                    :text="`${menu.items.length} itens no menu`" variant="info" />
            </template>

            <template v-slot:actions>
                <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.menus.edit', {
                    menu: menu.id
                })" />

                <ButtonConfirmationUi v-if="menu.can.delete" confirm-text="Excluir?"
                    icon="trash" variant="danger" size="sm" class="ms-2" position="right"
                    :data-action="$route('admin.menus.destroy',
                    { menu: menu.id })" confirm-with-request />
            </template>
        </ListItem>
    </div>

    <PaginationUi label="Paginação de menus" :pages="menus?.meta?.links" />

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
        menus: { type: Object, default: [] },
        isFiltering: { type: Boolean, default: false },
    },

    data() {
        return {
        };
    },

    mounted() {
    },

    methods: {
    },

    computed: {
    }
}

</script>