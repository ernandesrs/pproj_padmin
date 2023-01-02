<template>
    <ListGroup :is-filtering="isFiltering" :total-items="menus.data.length"
        :pagination-pages="menus?.meta?.links">
        <ListItem v-for="menu in menus?.data" :key="menu.id" :item="{
    cover: null,
    title: menu.name,
    subtitle: '',
    coverStyle: 'rectangle',
    actions: {
        show: null,
        edit: $route('admin.menus.edit', {
            id:
                menu.id
        }),
        delete: menu.can.delete ? $route('admin.menus.destroy',
            { menu: menu.id }) : null
    }
}">
            <template v-slot:badges>
                <BadgeUi class="mb-1 me-1 fw-light"
                    :text="`${menu.items.length} itens no menu`" variant="info" />
            </template>
        </ListItem>
    </ListGroup>

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import ListGroup from '../../../../Components/List/ListGroup.vue';
import ListItem from './../../../../Components/List/ListItem.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';
import BadgeUi from '../../../../Components/Ui/BadgeUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, CardUi, BadgeUi, ListGroup },

    props: {
        menus: { type: Object, default: [] },
        isFiltering: { type: Boolean, default: false },
    },
}

</script>