<template>

    <ListGroup :is-filtering="isFiltering" :total-items="pages.data.length"
        :pagination-pages="pages?.meta?.links">
        <ListItem v-for="page in pages?.data" :key="page.id" :item="{
    cover: page.thumb_small,
    title: page.title,
    subtitle: page.description,
    coverStyle: 'rectangle'
}">
            <template v-slot:badges>
                <BadgeUi class="mb-1 me-1"
                    :text="`${$helpers.string.substr(page?.author?.first_name, 8)}`"
                    icon="user" variant="dark" />

                <BadgeUi class="mb-1 me-1"
                    :text="`${terms.status[('status_' + page.status)]}`"
                    :icon="page.status == 1 ? 'fileEarmarkText' : (page.status == 2 ? 'calendarDate' : 'calendarCheck')"
                    :variant="`${page.status == 1 ? 'secondary' : (page.status == 2 ? 'info' : 'success')}`" />

                <BadgeUi class="mb-1 me-1"
                    :text="`${terms.type[('type_' + page.content_type)]}`"
                    :icon="page.content_type == 1 ? 'textLeft' : 'app'"
                    variant="secondary" />
            </template>

            <template v-slot:actions>
                <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.pages.edit', {
    page:
        page.id
})" />

                <ButtonConfirmationUi v-if="page.can?.delete" confirm-text="Excluir?"
                    icon="trash" variant="danger" size="sm" class="ms-2" position="right"
                    :data-action="$route('admin.pages.destroy',
    { page: page.id })" confirm-with-request request-method="delete" />
            </template>
        </ListItem>
    </ListGroup>

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import ListGroup from '../../../Components/List/ListGroup.vue';
import ListItem from '../../../Components/List/ListItem.vue';
import BadgeUi from '../../../Components/Ui/BadgeUi.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../Components/Ui/ButtonConfirmationUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, BadgeUi, ButtonUi, ButtonConfirmationUi, ListGroup, ListItem },
    props: {
        pages: { type: Object, default: [] },
        terms: { type: Object, default: {} },
        isFiltering: { type: Boolean, default: false },
    },
};

</script>