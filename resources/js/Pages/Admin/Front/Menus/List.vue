<template>
    <ListGroup :is-filtering="isFiltering" :total-items="menus.data.length"
        :pagination-pages="menus?.meta?.links">
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
    { menu: menu.id })" confirm-with-request request-method="delete" />
            </template>
        </ListItem>
    </ListGroup>

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import ListGroup from '../../../../Components/List/ListGroup.vue';
import ListItem from './../../../../Components/List/ListItem.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../../Components/Ui/ButtonConfirmationUi.vue';
import BadgeUi from '../../../../Components/Ui/BadgeUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, CardUi, ButtonUi, ButtonConfirmationUi, BadgeUi, ListGroup },

    props: {
        menus: { type: Object, default: [] },
        isFiltering: { type: Boolean, default: false },
    },
}

</script>