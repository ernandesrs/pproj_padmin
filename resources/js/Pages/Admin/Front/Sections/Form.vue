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
                                { value: 2, text: 'Banner único com imagens' }
                            ]" v-model="form.type" :error-message="form.errors.type"
                                only-values :disabled="form.id ? true : false" />
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

                    <div v-if="form.type == 0" class="mb-4">
                        <InputForm type="text" name="subtitle" v-model="form.subtitle"
                            label="Subtítulo:" :error-message="form.errors.subtitle" />
                    </div>

                    <div class="mb-4">
                        <label class="mb-1">{{ form.type == 0 ?
                                'Conteúdo' : 'Descrição'
                        }}:</label>
                        <EditorTiny v-model="tinyEditor" :api-key="tinyApiKey" basic
                            min-height=200 />
                        <small class="text-danger" v-if="tinyEditorError">{{
                                tinyEditorError
                        }}</small>
                    </div>
                </div>

                <div class="col-12 col-md-10 col-lg-6 mb-4">
                    <div class="mb-4">
                        <CardUi no-shadow border>
                            <template v-slot:content>
                                <div v-if="form.type != 2">
                                    <div class="fs-5 mb-3 fw-semibold">
                                        Imagem da seção
                                    </div>

                                    <div
                                        class="d-flex flex-column justify-content-center align-items-center mb-3">
                                        <ImagePreviewUi :preview-url="imagePreview"
                                            :borderless="imagePreview ? true : false" />
                                    </div>

                                    <!-- cover upload -->
                                    <div class="text-center">
                                        <ButtonUi @click="modalImagesListShow"
                                            :text="`${imagePreview ? 'Atualizar imagem' : 'Escolher imagem'}`"
                                            icon="image" variant="success" size="sm" />
                                    </div>
                                </div>

                                <div v-else>
                                    <div class="fs-5 mb-3 fw-semibold">
                                        Imagens da seção
                                    </div>

                                    <ul class="nav nav-pills align-items-center mb-3">
                                        <li v-for="image, key in form.content.images"
                                            :key="key" class="nav-item">
                                            <button
                                                :class="['nav-link fs-6 px-3 py-1', { 'active': key == 0 }]"
                                                data-bs-toggle="pill"
                                                :data-bs-target="`#tab-${(key + 1)}`"
                                                type="button">
                                                Imagem {{ (key + 1) }}
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content mb-3">
                                        <div v-for="image, key in form.content.images"
                                            :key="key"
                                            :class="['tab-pane fade show', { 'active': key == 0 }]"
                                            :id="`tab-${(key + 1)}`">

                                            <div
                                                class="d-flex flex-column justify-content-center align-items-center mb-3">
                                                <ImagePreviewUi :preview-url="image.url"
                                                    :borderless="image.url ? true : false" />
                                            </div>

                                            <!-- cover upload -->
                                            <div
                                                class="d-flex justify-content-center gap-2">
                                                <ButtonConfirmationUi
                                                    @hasConfirmed="removeImageField"
                                                    @hasCanceled=""
                                                    :text="`${'Excluir'} `" icon="trash"
                                                    variant="danger" size="sm"
                                                    position="center" :data-item="key" />

                                                <ButtonUi @click="modalImagesListShow"
                                                    :text="`${image.url ? 'Atualizar' : 'Escolher'} `"
                                                    icon="image" variant="success"
                                                    size="sm" :data-item="key" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <ButtonUi @click="addNewImageField"
                                            text="Adicionar imagem" icon="plusLg"
                                            variant="primary" size="sm" />
                                    </div>
                                </div>
                            </template>
                        </CardUi>
                    </div>

                    <!-- buttons/link -->
                    <div class="mb-4">
                        <CardUi no-shadow border>
                            <template v-slot:content>
                                <div class="fs-5 mb-3 fw-semibold">
                                    Links da seção
                                </div>

                                <div v-if="this.form.buttons.length > 2"
                                    class="border border-danger text-danger text-center py-2 mb-2">
                                    Recomendamos no máximo 2 links por seção!
                                </div>

                                <div class="mb-3">
                                    <AccordionGroup>
                                        <AccordionItem
                                            v-for="button, index in form.buttons"
                                            :key="index" :header-text="button.text"
                                            :id="index">
                                            <div class="row">
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <InputForm label="Texto:"
                                                        v-model="button.text"
                                                        :error-message="form.errors[`buttons.${index}.text`]" />
                                                </div>
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <InputForm label="Título:"
                                                        v-model="button.title"
                                                        :error-message="form.errors[`buttons.${index}.title`]" />
                                                </div>
                                                <div class="col-12 col-lg-6 mb-3">
                                                    <InputForm label="URL:"
                                                        v-model="button.url"
                                                        :error-message="form.errors[`buttons.${index}.url`]" />
                                                </div>
                                                <div class="col-6 col-lg-3 mb-3">
                                                    <SelectForm label="Abrir na:"
                                                        :options="[
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
                                                <div class="col-6 col-lg-3 mb-3">
                                                    <SelectForm
                                                        @hasChange="changeButtonsOrder"
                                                        label="Ordem:"
                                                        v-model="button.order"
                                                        :options="options" only-values />
                                                </div>
                                                <div class="col-12 col-lg-4 mb-3">
                                                    <SelectForm label="Estilo:"
                                                        v-model="button.style" :options="[
                                                            { value: 'primary', text: 'Primário' },
                                                            { value: 'outline-primary', text: 'Primário bordado' },
                                                            { value: 'secondary', text: 'Secundário' },
                                                            { value: 'outline-secondary', text: 'Secundário bordado' },
                                                            { value: 'link', text: 'Link' },
                                                        ]" only-values />
                                                </div>
                                                <div class="col-6 col-lg-4 mb-3">
                                                    <InputForm label="Ícone:"
                                                        v-model="button.icon" />
                                                    <a @click.prevent="showHowItWorkModal = true"
                                                        href=""><small>Como
                                                            funciona?</small></a>
                                                </div>
                                                <div class="col-6 col-lg-4 mb-3">
                                                    <SelectForm label="Posição:"
                                                        v-model="button.position"
                                                        :options="[
                                                            { value: 'start', text: 'Início' },
                                                            { value: 'end', text: 'Final' },
                                                        ]" only-values />
                                                </div>
                                                <div class="col-12 text-center">
                                                    <ButtonConfirmationUi
                                                        @hasConfirmed="removeButton"
                                                        @hasCanceled="" icon="trash"
                                                        variant="danger" size="sm"
                                                        position="center"
                                                        :data-item="index" />
                                                </div>
                                            </div>
                                        </AccordionItem>
                                    </AccordionGroup>
                                </div>

                                <div v-if="form.buttons.length == 0"
                                    class="p-2 mb-3 border text-center">
                                    Não há links nesta seção
                                </div>

                                <div class="text-center">
                                    <ButtonUi @click="addNewButton" text="Adicionar link"
                                        variant="primary" icon="plusLg" size="sm" />
                                </div>
                            </template>
                        </CardUi>
                    </div>
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
import CardUi from '../../../../Components/Ui/CardUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ButtonConfirmationUi, SelectForm, TextAreaForm, EditorTiny, ImagePreviewUi, ModalImagesList, AccordionGroup, AccordionItem, ModalUi, CardUi },
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
                    content: null,
                    description: null,
                    insertImageOn: null,
                    images: [
                        {
                            id: null,
                            path: null,
                            url: null
                        }
                    ],
                },
                buttons: []
            }),
            tinyEditor: null,
            tinyEditorError: null,
            showImagesModalList: false,
            showHowItWorkModal: false,
            imagePreview: null,
        };
    },

    watch: {
        form: {
            deep: true,
            handler(nv) {
                let errors = nv.errors;

                this.tinyEditorError = null;
                if (errors["content.content"]) {
                    this.tinyEditorError = errors["content.content"];
                } else if (errors["content.description"]) {
                    this.tinyEditorError = errors["content.description"];
                }
            }
        }
    },

    created() {
        if (!this.section?.id) return;

        this.form.id = this.section.id;
        this.form.type = this.section.type;
        this.form.name = this.section.name;
        this.form.title = this.section.title;
        this.form.visible = this.section.visible;
        this.form.subtitle = this.section.subtitle;

        if (this.section.type == 0) {
            this.tinyEditor = this.section.content.content;
        } else if ([1, 2].includes(this.section.type)) {
            this.tinyEditor = this.section.content.description;
            if (this.section.type == 2) {
                this.form.content.images = this.section.content.images ?? [];
            }
        }

        this.imagePreview = this.section.content.image_url;
        this.form.buttons = this.section.buttons;

        this.updateButtonsOrder();
        this.updateImagesOrder();
    },

    methods: {
        submit() {
            let action = route("admin.sections.store");

            this.setContent();

            if (this.form?.id) {
                action = route('admin.sections.update', { section: this.section.id });
                this.form.put(action);
            } else {
                this.form.post(action);
            }
        },

        modalImagesListShow(event) {
            this.showImagesModalList = true;

            if (this.form.type == 2) {
                this.form.content.insertImageOn = event.target.getAttribute("data-item");
            }
        },

        modalImagesListClose() {
            this.showImagesModalList = false;
        },

        insertImage(data) {
            if (this.form.type == 2) {
                this.form.content.images[this.form.content.insertImageOn].id = data.id;
                this.form.content.images[this.form.content.insertImageOn].url = data.thumb_small;
            } else {
                this.imagePreview = data.thumb_small;
                this.form.content.image = data.id;
            }
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
                position: "start",
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

        setContent() {
            if (this.form.type == 0)
                this.form.content.content = this.tinyEditor;
            else
                this.form.content.description = this.tinyEditor;
        },

        addNewImageField() {
            this.form.content.images.push({
                id: null,
                path: null,
                url: null
            });
        },

        removeImageField(event) {
            let item = event.path[2].getAttribute("data-item");

            if (!item) return;

            this.form.content.images.splice(item, 1);
            this.updateImagesOrder();
        },

        updateImagesOrder() {
            this.form.content.images = this.form.content.images.map((item, index) => {
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