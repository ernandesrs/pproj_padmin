<template>

<EmptyList :show="!roles?.data?.length" :is-filter="isFiltering" />

<ListItem v-for="role in roles.data" :key="role.id" :item="{
    title: role.name,
    subtitle: ''
}">

    <template v-slot:actions>
        <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.roles.edit', {id:
        role.id})" />

        <ButtonConfirmationUi v-if="role.can.delete" confirm-text="Excluir?"
            icon="trash" variant="danger" size="sm" class="ms-2" position="right"
            :data-action="$route('admin.roles.destroy',
            {role: role.id})" confirm-with-request request-method="delete" />
    </template>
</ListItem>

<PaginationUi label="Paginação de funções" :pages="roles?.meta?.links" />

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import ListItem from '../../../Components/ListItem.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import PaginationUi from '../../../Components/PaginationUi.vue';
import ButtonConfirmationUi from '../../../Components/Ui/ButtonConfirmationUi.vue';
import EmptyList from '../../../Components/EmptyList.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, ButtonUi, PaginationUi, ButtonConfirmationUi, EmptyList },

    props: {
        roles: { type: Object, default: [] },
        isFiltering: { type: Boolean, default: false },
    },
}

</script>