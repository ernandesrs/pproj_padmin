<template>

    <div v-if="!users.data?.length"
        class="px-5 py-3 mt-2 mb-4 fs-5 fw-semibold text-center border text-muted">
        <span v-if="isFiltering">Sem resultados para sua filtragem!</span>
        <span v-else>Sem nada para listagem!</span>
    </div>

    <ListItem v-else v-for="user in users.data" :key="user.id" :item="{
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

            <ButtonConfirmationUi v-if="user.can.delete" @hasClicked="deleteClick"
                @hasConfirmed="deleteConfirm" @hasCanceled="deleteCancel"
                confirm-text="Excluir?" icon="trash" variant="danger" size="sm"
                :data-action="$route('admin.users.destroy',
                {user: user.id})" class="ms-2" position="right" />
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
import { Inertia } from '@inertiajs/inertia';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, ButtonUi, BadgeUi, PaginationUi, ButtonConfirmationUi },

    data() {
        return {
            terms: {}
        };
    },

    props: {
        users: { type: Object, default: [] },
        terms: { type: Object, default: {} },
        isFiltering: { type: Boolean, default: false },
    },

    methods: {
        deleteClick(e) {
            // 
        },
        deleteConfirm(e) {
            let action = e.target.getAttribute("data-action");

            if (!action) return;

            Inertia.post(action);
        },
        deleteCancel(e) {
            // 
        },
    },

    computed: {
    }
}

</script>