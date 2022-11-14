<template>
    <EmptyList :show="!sections?.data?.length" :is-filter="isFiltering" />

    <div class="row justify-content-center">
        <ListItem v-for="section in sections?.data" :key="section.id" :item="{
            cover: null,
            title: '[' + section.name + '] ' + section.title,
            subtitle: section.subtitle,
            coverStyle: 'rectangle'
        }">
            <template v-slot:badges>
                <BadgeUi class="mb-1 me-1 fw-light"
                    :text="section.visible ? 'Visível' : 'Oculto'"
                    :variant="section.visible ? 'info' : 'secondary'"
                    :icon="section.visible ? 'eye' : 'eyeSlash'" />
            </template>

            <template v-slot:actions>
                <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.sections.edit', {
                    section: section.id
                })" />

                <ButtonConfirmationUi confirm-text="Excluir?" icon="trash"
                    variant="danger" size="sm" class="ms-2" position="right" :data-action="$route('admin.sections.destroy',
                    { section: section.id })" confirm-with-request />
            </template>
        </ListItem>
    </div>

    <PaginationUi label="Paginação de seções" :pages="sections?.meta?.links" />

</template>

<script>

import EmptyList from '../../../../Components/EmptyList.vue';
import ListItem from './../../../../Components/ListItem.vue';
import PaginationUi from '../../../../Components/PaginationUi.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';
import Layout from './../../../../Layouts/Panel.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../../Components/Ui/ButtonConfirmationUi.vue';
import BadgeUi from '../../../../Components/Ui/BadgeUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { EmptyList, ListItem, PaginationUi, CardUi, ButtonUi, ButtonConfirmationUi, BadgeUi },

    props: {
        sections: { type: Object, default: [] },
        isFiltering: { type: Boolean, default: false },
    },

    data() {
        return {
        };
    },

    mounted() {
    },

    methods: {
    },

    computed: {
    }
}

</script>