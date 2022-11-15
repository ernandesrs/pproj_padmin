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

    <ModalImagesList :show="showImagesModalList" @modalClose="modalImagesListClose"
        @imageInsert="insertImage" />

    <form @submit.prevent="submit">
        <div class="card card-body border-0">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-6 mb-4">
                    <div class="row">
                        <div class="col-6 col-xl-5 mb-4">
                            <SelectForm label="Tipo de seção:" :options="[
                                { value: 0, text: 'Padrão' },
                                { value: 1, text: 'Banner único' },
                                { value: 2, text: 'Banner único com imagens' },
                                { value: 3, text: 'Slides de banner' },
                            ]" v-model="form.type" :error-message="form.errors.type" />
                        </div>

                        <div class="col-6 col-xl-7">
                            <InputForm type="text" name="name" v-model="form.name"
                                label="Nome da seção:"
                                :error-message="form.errors.name" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <InputForm type="text" name="title" v-model="form.title"
                            label="Título:" :error-message="form.errors.title" />
                    </div>
                    <div class="mb-4">
                        <InputForm type="text" name="subtitle" v-model="form.subtitle"
                            label="Subtítulo:" :error-message="form.errors.subtitle" />
                    </div>

                    <div class="mb-4">
                        <label class="mb-1">Conteúdo:</label>
                        <EditorTiny v-model="form.content.content" :api-key="tinyApiKey"
                            full min-height=200 />
                    </div>
                </div>

                <div class="col-12 col-md-10 col-lg-6 mb-4">
                    <div
                        class="d-flex flex-column justify-content-center align-items-center">
                        <ImagePreviewUi :preview-url="imagePreview"
                            :borderless="imagePreview ? true : false" />
                    </div>

                    <!-- cover upload -->
                    <div class="text-center mb-4">
                        <ButtonUi @click="modalImagesListShow"
                            :text="`${imagePreview ? 'Atualizar imagem' : 'Inserir imagem'}`"
                            icon="image" variant="success" size="sm" />
                    </div>

                    <div class="mb-4">
                        <div class="fs-5 mb-3 fw-semibold">Botões/links da seção</div>
                        <div v-if="this.form.buttons.length > 2"
                            class="border border-danger text-danger text-center py-2 mb-2">
                            Recomendamos no máximo 2 botões/links por seção!
                        </div>
                        <AccordionGroup>
                            <AccordionItem v-for="button, index in form.buttons"
                                :key="index" :header-text="button.text" :id="index">
                                <div class="row">
                                    <div class="col-12 col-sm-6 mb-3">
                                        <InputForm label="Texto:" v-model="button.text"
                                            :error-message="form.errors[`buttons.${index}.text`]" />
                                    </div>
                                    <div class="col-12 col-sm-6 mb-3">
                                        <InputForm label="Título:" v-model="button.title"
                                            :error-message="form.errors[`buttons.${index}.title`]" />
                                    </div>
                                    <div class="col-7 col-lg-7 mb-3">
                                        <InputForm label="URL:" v-model="button.url"
                                            :error-message="form.errors[`buttons.${index}.url`]" />
                                    </div>
                                    <div class="col-5 col-lg-5 mb-3">
                                        <SelectForm label="Estilo:" v-model="button.style"
                                            :options="[
                                                { value: 'primary', text: 'Primário' },
                                                { value: 'outline-primary', text: 'Primário bordado' },
                                                { value: 'secondary', text: 'Secundário' },
                                                { value: 'outline-secondary', text: 'Secundário bordado' },
                                                { value: 'link', text: 'Link' },
                                            ]" only-values />
                                    </div>
                                    <div class="col-6 mb-3">
                                        <InputForm label="Ícone:" v-model="button.icon" />
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
                                        ]" v-model="button.target"
                                            :error-message="form.errors[`buttons.${index}.target`]" />
                                    </div>
                                    <div class="col-3 mb-3">
                                        <SelectForm @hasChange="changeButtonsOrder"
                                            label="Ordem:" v-model="button.order"
                                            :options="options" only-values />
                                    </div>
                                    <div class="col-12 text-center">
                                        <ButtonConfirmationUi @hasConfirmed="removeButton"
                                            @hasCanceled="" icon="trash" variant="danger"
                                            size="sm" position="center"
                                            :data-item="index" />
                                    </div>
                                </div>
                            </AccordionItem>
                        </AccordionGroup>
                    </div>

                    <div class="mb-4 text-center">
                        <ButtonUi @click="addNewButton" text="Adicionar botão"
                            variant="primary" icon="plusLg" size="sm" />
                    </div>
                </div>

                <div class="col-12 mb-4 d-flex justify-content-center">
                    <InputForm label="Ocultar/Mostrar esta seção" type="checkbox"
                        name="visible" v-model="form.visible" />
                </div>

                <div class="col-12 text-center">
                    <ButtonUi type="submit" variant="primary"
                        :text="`${section.id ? 'Atualizar seção' : 'Salvar seção'}`"
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
import TextAreaForm from '../../../../Components/Form/TextAreaForm.vue';
import EditorTiny from '../../../../Components/EditorTiny.vue';
import ImagePreviewUi from '../../../../Components/Ui/ImagePreviewUi.vue';
import ModalImagesList from '../../Medias/Images/ModalImagesList.vue';
import AccordionGroup from '../../../../Components/Ui/Accordion/AccordionGroup.vue';
import AccordionItem from '../../../../Components/Ui/Accordion/AccordionItem.vue';
import ModalUi from '../../../../Components/Ui/ModalUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ButtonConfirmationUi, SelectForm, TextAreaForm, EditorTiny, ImagePreviewUi, ModalImagesList, AccordionGroup, AccordionItem, ModalUi },
    props: {
        section: { type: Object, default: {} },
        tinyApiKey: { type: String, default: null },
    },

    data() {
        return {
            form: useForm({
                id: null,
                type: 0,
                name: null,
                title: null,
                subtitle: null,
                visible: false,
                content: {
                    image: null,
                    content: null
                },
                buttons: []
            }),
            showImagesModalList: false,
            showHowItWorkModal: false,
            imagePreview: null
        };
    },

    mounted() {
        if (!this.section?.id) return;

        this.form.id = this.section.id;
        this.form.type = this.section.type;
        this.form.name = this.section.name;
        this.form.title = this.section.title;
        this.form.visible = this.section.visible;
        this.form.subtitle = this.section.subtitle;

        this.form.content.content = this.section.content.content;
        this.form.content.image = null;
        this.form.content.image_url = this.section.content.image_url;
        this.imagePreview = this.section.content.image_url;

        this.form.buttons = this.section.buttons;

        this.updateButtonsOrder();
    },

    methods: {
        submit() {
            let action = route("admin.sections.store");

            if (this.form?.id) {
                action = route('admin.sections.update', { section: this.section.id });
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
            this.imagePreview = data.thumb_small;
            this.form.content.image = data.id;
        },

        addNewButton() {
            let index = this.form.buttons.length + 1;

            this.form.buttons.unshift({
                text: "Link text #" + index,
                url: "#" + index,
                target: "_self",
                title: "Link title #" + index,
                icon: null,
                style: "primary",
            });
            this.updateButtonsOrder();
        },

        removeButton(event) {
            let item = event.path[2].getAttribute("data-item");

            if (!item) return;

            this.form.buttons.splice(item, 1);
            this.updateButtonsOrder();
        },

        changeButtonsOrder(event) {
            let max = this.form.buttons.length;
            let oldOrder = event.target._value;
            let newOrder = event.target.value;

            if (newOrder < 0 || newOrder > max) {
                this.form.buttons[oldOrder].order = oldOrder;
                return;
            }

            let bkp = this.form.buttons[newOrder];
            this.form.buttons[newOrder] = this.form.buttons[oldOrder];
            this.form.buttons[oldOrder] = bkp;

            this.updateButtonsOrder();
        },

        updateButtonsOrder() {
            this.form.buttons = this.form.buttons.map((item, index) => {
                item.order = index;
                return item;
            });
        },
    },

    computed: {
        options() {
            let numbers = Object.keys(new Array(this.form.buttons.length).fill(null)).map(Number);
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