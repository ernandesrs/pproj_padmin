<template>

    <ListItem v-for="user in users.data" :key="user.id" :item="{
        cover: 'https://via.placeholder.com/125x125?text=Photo',
        title: user.first_name + ' ' + user.last_name,
        subtitle: user.email,
        coverStyle: 'circle'
    }">
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

export default {
    components: { ListItem, ButtonUi },
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    props: {
        users: { type: Array, default: [] }
    },

    setup() {
        return {}
    },

    methods: {
        deleteConfirm() {
            if (!window.confirm("Tem certeza de que deseja excluir este usuário?"))
                return;
        }
    }
}

</script>