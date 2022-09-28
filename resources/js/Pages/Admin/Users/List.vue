<template>

    <ListItem v-for="user in users.data" :key="user.id" :item="{
        cover: user.thumb_small,
        title: user.first_name + ' ' + user.last_name,
        subtitle: user.email,
        coverStyle: 'circle'
    }">
        <template v-slot:badges>
            <BadgeUi class="mb-1 me-1" :text="terms.user.level[user.level]" icon="user" />
            <BadgeUi class="mb-1 me-1" :icon="`${user.email_verified_at ? 'checkLg':'xLg'}`"
                :text="`${user.email_verified_at ? 'Verificado':'Não verificado'}`"
                variant="secondary" />
        </template>

        <template v-slot:actions>
            <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.users.edit', {id:
            user.id})" />
            <span class="mx-1"></span>
            <ButtonUi @click="deleteConfirm" icon="trash" variant="danger" size="sm"
                outlined />
        </template>
    </ListItem>

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import ListItem from '../../../Components/ListItem.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import BadgeUi from '../../../Components/Ui/BadgeUi.vue';

export default {
    components: { ListItem, ButtonUi, BadgeUi },
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    props: {
        users: { type: Array, default: [] }
    },

    data() {
        return {
            terms: {
                user: {
                    level: {
                        1: 'Usuário',
                        5: 'Membro',
                        8: 'Administrador',
                        9: 'Super',
                    }
                }
            }
        };
    },

    methods: {
        deleteConfirm() {
            if (!window.confirm("Tem certeza de que deseja excluir este usuário?"))
                return;
        }
    }
}

</script>