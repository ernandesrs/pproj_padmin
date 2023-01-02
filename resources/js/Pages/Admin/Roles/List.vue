<template>

    <ListGroup :is-filtering="isFiltering" :total-items="roles.data.length"
        :pagination-pages="roles?.meta?.links">
        <ListItem v-for="role in roles.data" :key="role.id" :item="{
    title: role.name,
    subtitle: ''
}">
            <template v-slot:actions>
                <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.roles.edit', {
    id:
        role.id
})" />

                <ButtonConfirmationUi v-if="role.can.delete" confirm-text="Excluir?"
                    icon="trash" variant="danger" size="sm" class="ms-2" position="right"
                    :data-action="$route('admin.roles.destroy',
    { role: role.id })" confirm-with-request request-method="delete" />
            </template>
        </ListItem>
    </ListGroup>

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import ListGroup from '../../../Components/List/ListGroup.vue';
import ListItem from '../../../Components/List/ListItem.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../Components/Ui/ButtonConfirmationUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, ButtonUi, ButtonConfirmationUi, ListGroup },

    props: {
        roles: { type: Object, default: [] },
        isFiltering: { type: Boolean, default: false },
    },
}

</script>