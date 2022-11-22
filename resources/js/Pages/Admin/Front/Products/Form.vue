<template>

    <ModalImagesList :show="showImagesModalList" @modalClose="modalImagesListClose"
        @imageInsert="insertImage" />

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
                Então você poderá navegar entre os milhares de ícones existentes. Você
                pode facilmente
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
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <InputForm label="Nome do produto:" v-model="form.title"
                                    :error-message="form.errors.title" />
                            </div>

                            <div class="mb-4">
                                <InputForm label="Ícone:" v-model="form.icon"
                                    :error-message="form.errors.icon" />
                            </div>
                        </div>

                        <div
                            class="col-12 d-flex flex-column justify-content-center mb-4">
                            <div class="mb-3">
                                <ImagePreviewUi :preview-url="coverPreview"
                                    :borderless="coverPreview ? true : false" />
                            </div>

                            <!-- cover upload -->
                            <div class="text-center">
                                <ButtonUi @click="modalImagesListShow"
                                    :text="`${coverPreview ? 'Atualizar capa' : 'Inserir capa'}`"
                                    icon="image" variant="success" size="sm" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-4">
                                <InputForm label="Preço:" v-model="form.price"
                                    :error-message="form.errors.price" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-4">
                                <InputForm label="Preço antigo:" v-model="form.old_price"
                                    :error-message="form.errors.old_price" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <ButtonUi type="submit" variant="primary"
                        :text="`${product.id ? 'Atualizar produto' : 'Adicionar produto'}`"
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
import ImagePreviewUi from '../../../../Components/Ui/ImagePreviewUi.vue';
import ModalImagesList from '../../Medias/Images/ModalImagesList.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ButtonConfirmationUi, SelectForm, AccordionGroup, AccordionItem, ModalUi, ImagePreviewUi, ModalImagesList },
    props: {
        product: { type: Object, default: {} }
    },

    data() {
        return {
            form: useForm({
                id: null,
                title: null,
                price: null,
                old_price: null,
                image: null,
                icon: null
            }),
            showHowItWorkModal: false,
            showImagesModalList: false,
            coverPreview: null
        };
    },

    mounted() {
        if (!this.product?.id) return;

        this.form.id = this.product.id;
        this.form.title = this.product.title;
        this.form.price = this.product.price;
        this.form.old_price = this.product.old_price;
        this.form.image = this.product.image;
        this.form.icon = this.product.icon;
    },

    methods: {
        submit() {
            let action = route("admin.products.store");

            if (this.form?.id) {
                action = route('admin.products.update', { product: this.product.id });
                this.form.put(action);
            } else {
                this.form.post(action);
            }
        },

        modalImagesListShow() {
            this.showImagesModalList = true;
        },

        modalImagesListClose() {
            this.showImagesModalList = false;
        },

        insertImage(data) {
            this.coverPreview = data.thumb_small;
            this.form.image = data.id;
        }
    },
}

</script>