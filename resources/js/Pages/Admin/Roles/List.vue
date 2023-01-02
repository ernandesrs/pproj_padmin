<template>

    <ListGroup :is-filtering="isFiltering" :total-items="roles.data.length"
        :pagination-pages="roles?.meta?.links">
        <ListItem v-for="role in roles.data" :key="role.id" :item="{
    title: role.name,
    subtitle: '',
    actions: {
        show: null,
        edit: $route('admin.roles.edit', {
            id:
                role.id
        }),
        delete: role.can.delete ? $route('admin.roles.destroy',
            { role: role.id }) : null
    }
}">
        </ListItem>
    </ListGroup>

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import ListGroup from '../../../Components/List/ListGroup.vue';
import ListItem from '../../../Components/List/ListItem.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, ListGroup },

    props: {
        roles: { type: Object, default: [] },
        isFiltering: { type: Boolean, default: false },
    },
}

</script>