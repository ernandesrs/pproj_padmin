<template>
    <ModalIcons :show="showIconsModal" @modalClose="showIconsModal = false"
        @iconHasChoosed="iconHasChoosed" />

    <ModalIconHelp :show="showModalIconsHelp" @modalClose="showModalIconsHelp = false" />

    <form @submit.prevent="submit">
        <div class="card card-body border-0">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-5 mb-4">
                    <div class="mb-4">
                        <InputForm type="text" name="name" v-model="form.name"
                            label="Nome do menu:" :error-message="form.errors.name" />
                    </div>
                    <div class="text-center">
                        <ButtonUi @click="addMenuItem" type="button" variant="info"
                            text="Adicionar item ao menu" icon="plusLg" size="sm" />
                    </div>
                </div>

                <div class="col-12 col-md-10 col-lg-7 mb-4">
                    <AccordionGroup id="menu_links">
                        <SortableList v-model="form.items">
                            <template #item="{ item, index }">
                                <AccordionItem :id="index" :header-text="item.text">
                                    <div class="row" :data-index="index">
                                        <div class="col-12 col-sm-6 mb-3">
                                            <SelectForm label="Abrir na:" :options="[
                                                {
                                                    value: '_self',
                                                    text: 'Aba atual'
                                                },
                                                {
                                                    value: '_blank',
                                                    text: 'Outra aba'
                                                }
                                            ]" v-model="item.target"
                                                :error-message="form.errors[`items.${index}.target`]" />
                                        </div>

                                        <div class="col-12 col-sm-6 mb-3">
                                            <InputForm label="Texto:" v-model="item.text"
                                                :error-message="form.errors[`items.${index}.text`]" />
                                        </div>

                                        <div class="col-12 col-sm-6 mb-3">
                                            <InputForm label="Título:"
                                                v-model="item.title"
                                                :error-message="form.errors[`items.${index}.title`]" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <InputForm label="URL:" v-model="item.url"
                                                :error-message="form.errors[`items.${index}.url`]" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <IconSetter
                                                @requestingIconsModal="showIconModalAndUpdateLinkItemIndexUnderEdit"
                                                @requestingModalIconsHelp="showModalIconsHelp = true" :icon-data="item.icon" />
                                        </div>
                                    </div>
                                </AccordionItem>
                            </template>
                        </SortableList>
                    </AccordionGroup>
                </div>

                <div v-if="!menu?.id || menu?.id && menu.can.update"
                    class="col-12 text-center">
                    <ButtonUi type="submit" variant="primary"
                        :text="`${menu.id ? 'Atualizar menu' : 'Salvar menu'}`"
                        icon="checkLg" :disabled="form.processing" />
                </div>
            </div>
        </div>
    </form>

</template>

<script>

import { useForm } from '@inertiajs/inertia-vue3';
import Layout from './../../../../Layouts/Panel.vue';
import InputForm from '../../../../Components/Form/InputForm.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../../Components/Ui/ButtonConfirmationUi.vue';
import SelectForm from '../../../../Components/Form/SelectForm.vue';
import AccordionGroup from '../../../../Components/Ui/Accordion/AccordionGroup.vue';
import AccordionItem from '../../../../Components/Ui/Accordion/AccordionItem.vue';
import ModalUi from '../../../../Components/Ui/ModalUi.vue';
import IconSetter from '../../../../Components/IconSetter/IconSetter.vue';
import ModalIcons from '../../../../Components/IconSetter/ModalIcons.vue';
import ModalIconHelp from '../../../../Components/IconSetter/ModalIconHelp.vue';
import SortableList from '../../../../Components/List/Sortable/SortableList.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ButtonConfirmationUi, SelectForm, AccordionGroup, AccordionItem, ModalUi, IconSetter, ModalIcons, ModalIconHelp, SortableList },
    props: {
        menu: { type: Object, default: {} }
    },

    data() {
        return {
            form: useForm({
                id: null,
                name: null,
                items: []
            }),

            showModalIconsHelp: false,
            showIconsModal: false,
            linkItemIndex: -1,
        };
    },

    created() {
        if (!this.menu?.id) return;

        this.form.id = this.menu.id;
        this.form.name = this.menu.name;
        this.form.items = this.menu.items;

        console.log(this.form.items);
    },

    methods: {
        submit() {
            let action = route("admin.menus.store");

            if (this.form?.id) {
                action = route('admin.menus.update', { menu: this.menu.id });
                this.form.put(action);
            } else {
                this.form.post(action);
            }
        },

        addMenuItem() {
            let index = this.form.items.length + 1;

            this.form.items.unshift({
                text: "Menu text " + index,
                url: "https://example.com",
                target: "_self",
                title: "Menu item title " + index,
                icon: {
                    source: "local",
                    name: null,
                    class: null,
                    position: "start"
                },
            });
        },

        /**
         * ICON
         */
        showIconModalAndUpdateLinkItemIndexUnderEdit(event) {
            this.showIconsModal = true;
            this.linkItemIndex = parseInt(event.path[5].getAttribute("data-index"));s
        },

        iconHasChoosed(icon) {
            this.showIconsModal = false;
            this.form.items[this.linkItemIndex].icon.class = icon.class;
            this.form.items[this.linkItemIndex].icon.name = icon.name;
        },
    },

    computed: {
        options() {
            let numbers = Object.keys(new Array(this.form.items.length).fill(null)).map(Number);
            let options = numbers.map((item) => {
                return {
                    text: item + 1,
                    value: item
                };
            });
            return options;
        }
    }
}

</script>