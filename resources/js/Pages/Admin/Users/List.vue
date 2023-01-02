<template>

    <ListGroup :is-filtering="isFiltering" :total-items="users.data.length"
        :pagination-pages="users?.meta?.links">
        <ListItem v-for="user in users.data" :key="user.id" :item="{
    cover: user.thumb_small,
    title: user.first_name + ' ' + user.last_name,
    subtitle: user.email,
    coverStyle: 'circle'
}">
            <template v-slot:badges>
                <BadgeUi v-if="user.role?.id || user.is_superadmin" class="mb-1 me-1"
                    :text="user.is_superadmin ? 'Superadmin' : user.role.name"
                    icon="user" />
                <BadgeUi class="mb-1 me-1"
                    :icon="`${user.email_verified_at ? 'checkLg' : 'xLg'}`"
                    :text="`${user.email_verified_at ? 'Verificado' : 'Não verificado'}`"
                    variant="secondary" />
            </template>

            <template v-slot:actions>
                <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.users.edit', {
    id:
        user.id
})" />

                <ButtonConfirmationUi v-if="user.can.delete" confirm-text="Excluir?"
                    icon="trash" variant="danger" size="sm" class="ms-2" position="right"
                    :data-action="$route('admin.users.destroy',
    { user: user.id })" confirm-with-request request-method="delete" />
            </template>
        </ListItem>
    </ListGroup>

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import ListGroup from '../../../Components/List/ListGroup.vue';
import ListItem from '../../../Components/List/ListItem.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import BadgeUi from '../../../Components/Ui/BadgeUi.vue';
import ButtonConfirmationUi from '../../../Components/Ui/ButtonConfirmationUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, ButtonUi, BadgeUi, ButtonConfirmationUi, ListGroup },

    props: {
        users: { type: Object, default: [] },
        terms: { type: Object, default: {} },
        isFiltering: { type: Boolean, default: false },
    },
}

</script>