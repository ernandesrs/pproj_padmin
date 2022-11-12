<template>

    <ModalUi :show="showHowItWorkModal" @modalClose="showHowItWorkModal = false"
        size="lg">
        <h1 class="fs-4">Conheça</h1>
        <p>
            Este sistema se utiliza de uma poderosa e conhecida biblioteca de ícones,
            o <a href="https://icons.getbootstrap.com" target="_blank"
                title="Bootstrap Icons">
                Bootstrap Icons</a>! Esta biblioteca possui quase 2.000 ícones e eles
            estão todos disponíveis
            para você!
        </p>
        <h1 class="fs-4">Como inserir?</h1>
        <p>
            Para inserir um ícone é simples! Você precisa obter a tag html do ícone e
            colar no campo de ícones no formulário. Se possui dúvidas, siga os passos
            abaixo:
        </p>
        <ol>
            <li>
                Acesse <a href="https://icons.getbootstrap.com" target="_blank"
                    title="Bootstrap Icons"> https://icons.getbootstrap.com</a>
            </li>
            <li>
                Então você poderá navegar entre os milhares de ícones existentes. Você pode facilmente
                encontrar um ícone utilizando o campo de filtragem. Clique sobre o ícone
                escolhido.
            </li>
            <li>
                Na página do ícone à direita(em desktop) você terá diversas formas de
                obter este ícone, dentre elas a opção <strong>Icon font</strong>. Copie o
                código HTML indicado.
            </li>
            <li>
                Volte para este painel e cole o código obtido no campo
                <strong>Ícone</strong> e então <strong>salve as alterações</strong>.
            </li>
            <li>
                Pronto! Você já inseriu um ícone para o seu link ou botão.
            </li>
        </ol>
    </ModalUi>

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
                            :header-text="item.text">
                            <div class="row">
                                <div class="col-12 col-sm-6 mb-3">
                                    <InputForm label="Texto:" v-model="item.text"
                                        :error-message="form.errors[`items.${key}.text`]" />
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <InputForm label="Título:" v-model="item.title"
                                        :error-message="form.errors[`items.${key}.title`]" />
                                </div>
                                <div class="col-12 mb-3">
                                    <InputForm label="URL:" v-model="item.url"
                                        :error-message="form.errors[`items.${key}.url`]" />
                                </div>
                                <div class="col-6 mb-3">
                                    <InputForm label="Ícone:" v-model="item.icon" />
                                    <a @click.prevent="showHowItWorkModal = true"
                                        href=""><small>Como funciona?</small></a>
                                </div>
                                <div class="col-3 mb-3">
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
                                <div class="col-3 mb-3">
                                    <SelectForm @hasChange="changeOrder" label="Ordem:"
                                        v-model="item.order" :options="options"
                                        only-values />
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

                <div class="col-12 text-center">
                    <ButtonUi type="submit" variant="primary"
                        :text="`${menu.id ? 'Atualizar menu' : 'Salvar menu'}`"
                        icon="checkLg" :disabled="form.processing" />
                </div>
            </div>
        </div>
    </form>

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import InputForm from '../../../../Components/Form/InputForm.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../../Components/Ui/ButtonConfirmationUi.vue';
import SelectForm from '../../../../Components/Form/SelectForm.vue';
import AccordionGroup from '../../../../Components/Ui/Accordion/AccordionGroup.vue';
import AccordionItem from '../../../../Components/Ui/Accordion/AccordionItem.vue';
import ModalUi from '../../../../Components/Ui/ModalUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ButtonConfirmationUi, SelectForm, AccordionGroup, AccordionItem, ModalUi },
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
            showHowItWorkModal: false
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

            if (this.form?.id)
                action = route('admin.menus.update', { menu: this.menu.id });

            this.form.items = this.items;

            this.form.post(action);
        },

        addMenuItem() {
            this.items.unshift({
                text: "Menu item text",
                url: "https://example.com",
                target: "_self",
                title: "Menu item title",
                icon: null,
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