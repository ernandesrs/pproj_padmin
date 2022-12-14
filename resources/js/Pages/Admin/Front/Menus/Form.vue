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
                    <AccordionGroup>
                        <AccordionItem v-for="item, key in items" :key="key" :id="key"
                            :header-text="item.text"
                            @showedIndexHasUpdated="updateButtonIndex">
                            <div class="row">
                                <div class="col-12 col-sm-6 mb-3">
                                    <SelectForm @hasChange="changeOrder" label="Ordem:"
                                        v-model="item.order" :options="options"
                                        only-values />
                                </div>

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
                                        :error-message="form.errors[`items.${key}.target`]" />
                                </div>

                                <div class="col-12 col-sm-6 mb-3">
                                    <InputForm label="Texto:" v-model="item.text"
                                        :error-message="form.errors[`items.${key}.text`]" />
                                </div>

                                <div class="col-12 col-sm-6 mb-3">
                                    <InputForm label="T??tulo:" v-model="item.title"
                                        :error-message="form.errors[`items.${key}.title`]" />
                                </div>

                                <div class="col-12 mb-3">
                                    <InputForm label="URL:" v-model="item.url"
                                        :error-message="form.errors[`items.${key}.url`]" />
                                </div>

                                <div class="col-12 mb-3">
                                    <IconSetter @iconHasSet="iconHasSet"
                                        @requestingIconsModal="showIconsModal = true"
                                        @requestingModalIconsHelp="showModalIconsHelp = true"
                                        :icon-data="item.icon" />
                                </div>

                                <div class="col-12 text-center">
                                    <ButtonConfirmationUi @hasConfirmed="removeItem"
                                        @hasCanceled="" icon="trash" variant="danger"
                                        size="sm" position="center" :data-item="key" />
                                </div>
                            </div>
                        </AccordionItem>
                    </AccordionGroup>
                </div>

                <div v-if="!menu?.id || menu?.id && menu.can.update" class="col-12 text-center">
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

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ButtonConfirmationUi, SelectForm, AccordionGroup, AccordionItem, ModalUi, IconSetter, ModalIcons, ModalIconHelp },
    props: {
        menu: { type: Object, default: {} }
    },

    data() {
        return {
            form: useForm({
                id: null,
                name: null,
                items: null
            }),
            items: [],

            showModalIconsHelp: false,
            showIconsModal: false,
            buttonIndex: -1,
        };
    },

    mounted() {
        if (!this.menu?.id) return;

        this.form.id = this.menu.id;
        this.form.name = this.menu.name;
        this.items = this.menu.items;

        this.updateItemsOrder();
    },

    methods: {
        submit() {
            let action = route("admin.menus.store");
            this.form.items = this.items;

            if (this.form?.id) {
                action = route('admin.menus.update', { menu: this.menu.id });
                this.form.put(action);
            } else {
                this.form.post(action);
            }
        },

        addMenuItem() {
            this.items.unshift({
                text: "Menu item text",
                url: "https://example.com",
                target: "_self",
                title: "Menu item title",
                icon: {
                    source: "local",
                    name: null,
                    class: null,
                    position: "start"
                },
            });

            this.updateItemsOrder();
        },

        removeItem(event) {
            let item = event.path[2].getAttribute("data-item");

            if (!item) return;

            this.items.splice(item, 1);
            this.updateItemsOrder();
        },

        changeOrder(event) {
            let max = this.items.length;
            let oldOrder = event.target._value;
            let newOrder = event.target.value;

            if (newOrder < 0 || newOrder > max) {
                this.items[oldOrder].order = oldOrder;
                return;
            }

            let bkp = this.items[newOrder];
            this.items[newOrder] = this.items[oldOrder];
            this.items[oldOrder] = bkp;

            this.updateItemsOrder();
        },

        updateItemsOrder() {
            this.items = this.items.map((item, index) => {
                item.order = index;
                return item;
            });
        },

        updateButtonIndex(nindex) {
            this.buttonIndex = nindex;
        },

        /**
         * ICON
         */

        iconHasChoosed(icon) {
            this.showIconsModal = false;
            this.items[this.buttonIndex].icon.class = icon.class;
            this.items[this.buttonIndex].icon.name = icon.name;
        },

        iconHasSet(icon) {
            this.items[this.buttonIndex].icon = icon;
        }
    },

    computed: {
        options() {
            let numbers = Object.keys(new Array(this.items.length).fill(null)).map(Number);
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