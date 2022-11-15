<template>

    <EmptyList :show="!users?.data?.length" :is-filter="isFiltering" />

    <ListItem v-for="user in users.data" :key="user.id" :item="{
        cover: user.thumb_small,
        title: user.first_name + ' ' + user.last_name,
        subtitle: user.email,
        coverStyle: 'circle'
    }">
        <template v-slot:badges>
            <BadgeUi class="mb-1 me-1" :text="terms?.level['level_' + user.level]"
                icon="user" />
            <BadgeUi class="mb-1 me-1"
                :icon="`${user.email_verified_at ? 'checkLg':'xLg'}`"
                :text="`${user.email_verified_at ? 'Verificado':'Não verificado'}`"
                variant="secondary" />
        </template>

        <template v-slot:actions>
            <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.users.edit', {id:
            user.id})" />

            <ButtonConfirmationUi v-if="user.can.delete" confirm-text="Excluir?"
                icon="trash" variant="danger" size="sm" class="ms-2" position="right"
                :data-action="$route('admin.users.destroy',
                {user: user.id})" confirm-with-request request-method="delete" />
        </template>
    </ListItem>

    <PaginationUi label="Paginação de usuários" :pages="users?.meta?.links" />

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import ListItem from '../../../Components/ListItem.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import BadgeUi from '../../../Components/Ui/BadgeUi.vue';
import PaginationUi from '../../../Components/PaginationUi.vue';
import ButtonConfirmationUi from '../../../Components/Ui/ButtonConfirmationUi.vue';
import EmptyList from '../../../Components/EmptyList.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, ButtonUi, BadgeUi, PaginationUi, ButtonConfirmationUi, EmptyList },

    data() {
        return {
        };
    },

    props: {
        users: { type: Object, default: [] },
        terms: { type: Object, default: {} },
        isFiltering: { type: Boolean, default: false },
    },

    methods: {
    },

    computed: {
    }
}

</script>