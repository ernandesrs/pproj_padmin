<template>
    <EmptyList :show="!services?.data?.length" :is-filter="isFiltering" />

    <div class="row justify-content-center">
        <ListItem v-for="service in services?.data" :key="service.id" :item="{
            cover: null,
            title: service.title,
            subtitle: service.description,
            coverStyle: 'square'
        }">
            <template v-slot:cover>
                <div class="d-flex justify-content-center align-items-center fs-5"
                    style="width:50px;height:50px;">
                    <template v-if="service.icon">
                        <span v-if="service.icon.name"
                            :class="$icons[service.icon.name]"></span>
                        <span v-else :class="service.icon.class"></span>
                    </template>
                </div>
            </template>

            <template v-slot:actions>
                <ButtonUi icon="pencilSquare" variant="primary" size="sm" :to="$route('admin.services.edit', {
                    service: service.id
                })" />

                <ButtonConfirmationUi v-if="service.can.delete" confirm-text="Excluir?" icon="trash"
                    variant="danger" size="sm" class="ms-2" position="right" :data-action="$route('admin.services.destroy',
                    { service: service.id })" confirm-with-request
                    request-method="delete" />
            </template>
        </ListItem>
    </div>

    <PaginationUi label="Paginação de serviços" :pages="services?.meta?.links" />

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
        services: { type: Object, default: [] },
        isFiltering: { type: Boolean, default: false },
    },
}

</script>