<template>
    <ListGroup :is-filtering="isFiltering" :total-items="sections.data.length"
        :pagination-pages="sections?.meta?.links">
        <ListItem v-for="section in sections?.data" :key="section.id" :item="{
            cover: null,
            title: section.name,
            subtitle: section.title,
            coverStyle: 'rectangle',
            actions: {
                show: null,
                edit: $route('admin.sections.edit', {
                    id:
                        section.id
                }),
                delete: section.can.delete ? $route('admin.sections.destroy',
                    { section: section.id }) : null
            }
        }">
            <template v-slot:badges>
                <BadgeUi class="mb-1 me-1 fw-light"
                    :text="section.visible ? 'Visível' : 'Oculto'"
                    :variant="section.visible ? 'info' : 'secondary'"
                    :icon="section.visible ? 'eye' : 'eyeSlash'" />
                <BadgeUi class="mb-1 me-1 fw-light"
                    :text="`Tipo de seção: ${terms.type['type_' + section.type]} `"
                    variant="warning" />
            </template>
        </ListItem>
    </ListGroup>

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import ListGroup from '../../../../Components/List/ListGroup.vue';
import ListItem from './../../../../Components/List/ListItem.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';
import BadgeUi from '../../../../Components/Ui/BadgeUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { ListItem, CardUi, BadgeUi, ListGroup },

    props: {
        sections: { type: Object, default: [] },
        isFiltering: { type: Boolean, default: false },
        terms: { type: Object, default: {} }
    }
}

</script>