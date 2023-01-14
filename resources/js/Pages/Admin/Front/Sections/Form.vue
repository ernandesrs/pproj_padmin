<template>

    <ModalIcons @icon-has-choosed="iconHasChoosed" :show="showIconsModal"
        @modalClose="showIconsModal = false" />

    <ModalIconHelp :show="showModalIconsHelp" @modalClose="showModalIconsHelp = false" />

    <ModalImagesList :show="showImagesModalList" @modalClose="modalImagesListClose"
        @imageInsert="insertImage" />

    <form @submit.prevent="submit">
        <div class="card card-body border-0">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-6 mb-4">
                    <div class="row">
                        <div class="col-6 col-xl-5 mb-4">
                            <SelectForm label="Tipo de seção:"
                                :options="sectionTypesOptions" v-model="form.type"
                                :error-message="form.errors.type" only-values
                                :disabled="form.id ? true : false" />
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

                    <div v-if="['bindable', 'default'].includes(form.type)" class="mb-4">
                        <InputForm type="text" name="subtitle" v-model="form.subtitle"
                            label="Subtítulo:" :error-message="form.errors.subtitle" />
                    </div>

                    <div v-if="['default', 'banner'].includes(form.type)" class="mb-4">
                        <label class="mb-1">
                            Conteúdo
                        </label>
                        <EditorTiny v-model="tinyEditor" :api-key="tinyApiKey" basic
                            min-height=200 />
                        <small class="text-danger" v-if="tinyEditorError">
                            {{ tinyEditorError }}
                        </small>
                    </div>

                    <div class="mb-4">
                        <SelectForm v-if="['bindable'].includes(form.type)"
                            label="Vincular com:" :options="bindablesOptions"
                            v-model="form.bindable_class"
                            :error-message="form.errors.bindable_class" />
                    </div>
                </div>

                <div class="col-12 col-md-10 col-lg-6 mb-4">
                    <!-- images -->
                    <div class="mb-4 d-none">
                        <CardUi no-shadow border
                            v-if="['banner', 'default'].includes(form.type)">
                            <template v-slot:content>
                                <div>
                                    <div class="fs-5 mb-3 fw-semibold">
                                        Imagens da seção
                                    </div>

                                    <TabpanelUi pills navs-alignment="center">
                                        <template v-slot:tabNavs>
                                            <TabNavItem v-for="image, key in form.images"
                                                :key="key" :name="`image${key}`"
                                                :content-name="`image${key}Panel`"
                                                :text="`${(key + 1)}`"
                                                :show="key == 0 ? true : false" />
                                        </template>

                                        <template v-slot:tabContents>
                                            <TabContent v-for="image, key in form.images"
                                                :key="key" :name="`image${key}Panel`"
                                                :nav-name="`image${key}`"
                                                :show="key == 0 ? true : false">

                                                <!-- image preview -->
                                                <div
                                                    class="d-flex flex-column justify-content-center align-items-center mb-3">
                                                    <ImagePreviewUi
                                                        :preview-url="image.url"
                                                        :borderless="image.url ? true : false" />
                                                </div>

                                                <div class="mb-3">
                                                    <InputForm
                                                        label="Duração em milisegundos:"
                                                        v-model="image.duration"
                                                        :error-message="form.errors['images.' + key + '.duration']"
                                                        :mask="['####', '#####']" />
                                                </div>

                                                <!-- image delete/upload -->
                                                <div
                                                    class="d-flex justify-content-center gap-2">
                                                    <ButtonConfirmationUi
                                                        @hasConfirmed="removeImage"
                                                        @hasCanceled=""
                                                        :text="`${'Excluir'} `"
                                                        icon="trash" variant="danger"
                                                        size="sm" position="center"
                                                        :data-item="key" />

                                                    <ButtonUi @click="modalImagesListShow"
                                                        :text="`${image.url ? 'Atualizar' : 'Escolher'} `"
                                                        icon="image" variant="success"
                                                        size="sm" :data-item="key" />
                                                </div>

                                            </TabContent>
                                        </template>
                                    </TabpanelUi>

                                    <div class="text-center">
                                        <ButtonUi @click="addNewImage"
                                            text="Adicionar imagem" icon="plusLg"
                                            variant="link" size="sm" />
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
                                    <div class="text-center">
                                        <ButtonUi @click="addNewButton"
                                            text="Adicionar link" variant="link"
                                            icon="plusLg" size="sm" />
                                    </div>
                                    <AccordionGroup id="sections_buttons_links">
                                        <SortableList v-model="form.buttons">
                                            <template #item="{ item, index }">
                                                <AccordionItem :header-text="item.text"
                                                    :id="index">
                                                    <div class="row" :data-index="index">
                                                        <div class="col-6 col-xl-6 mb-3">
                                                            <SelectForm label="Estilo:"
                                                                v-model="item.style"
                                                                :options="[
                                                                    { value: 'primary', text: 'Primário' },
                                                                    { value: 'outline-primary', text: 'Primário bordado' },
                                                                    { value: 'secondary', text: 'Secundário' },
                                                                    { value: 'outline-secondary', text: 'Secundário bordado' },
                                                                    { value: 'link', text: 'Link' },
                                                                ]" only-values />
                                                        </div>
                                                        <div class="col-12 col-sm-6 mb-3">
                                                            <InputForm label="Texto:"
                                                                v-model="item.text"
                                                                :error-message="form.errors[`buttons.${index}.text`]" />
                                                        </div>
                                                        <div class="col-12 col-sm-6 mb-3">
                                                            <InputForm label="Título:"
                                                                v-model="item.title"
                                                                :error-message="form.errors[`buttons.${index}.title`]" />
                                                        </div>
                                                        <div
                                                            class="col-12 col-sm-6 col-lg-8 mb-3">
                                                            <InputForm label="URL:"
                                                                v-model="item.url"
                                                                :error-message="form.errors[`buttons.${index}.url`]" />
                                                        </div>
                                                        <div
                                                            class="col-12 col-sm-6 col-lg-4 mb-3">
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
                                                                ]" v-model="item.target"
                                                                :error-message="form.errors[`buttons.${index}.target`]" />
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <IconSetter
                                                                @requestingIconsModal="showIconModalAndUpdateLinkIndexUnderEdit"
                                                                @requestingModalIconsHelp="showModalIconsHelp = true"
                                                                :icon-data="item.icon" />
                                                        </div>
                                                    </div>
                                                </AccordionItem>
                                            </template>
                                        </SortableList>
                                    </AccordionGroup>
                                </div>

                                <div v-if="form.buttons.length == 0"
                                    class="p-2 mb-3 border text-center">
                                    Não há links nesta seção
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

            <div v-if="!section?.id || section?.id && section.can.update"
                class="col-12 text-center">
                <ButtonUi type="submit" variant="primary"
                    :text="`${section.id ? 'Atualizar seção' : 'Salvar seção'}`"
                    icon="checkLg" :disabled="form.processing" />
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
import TextAreaForm from '../../../../Components/Form/TextAreaForm.vue';
import EditorTiny from '../../../../Components/EditorTiny.vue';
import ImagePreviewUi from '../../../../Components/Ui/ImagePreviewUi.vue';
import ModalImagesList from '../../Medias/Images/ModalImagesList.vue';
import AccordionGroup from '../../../../Components/Ui/Accordion/AccordionGroup.vue';
import AccordionItem from '../../../../Components/Ui/Accordion/AccordionItem.vue';
import ModalUi from '../../../../Components/Ui/ModalUi.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';
import TabpanelUi from '../../../../Components/Ui/Tabpanel/TabpanelUi.vue';
import TabNavItem from '../../../../Components/Ui/Tabpanel/TabNavItem.vue';
import TabContent from '../../../../Components/Ui/Tabpanel/TabContent.vue';
import ModalIcons from '../../../../Components/IconSetter/ModalIcons.vue';
import ModalIconHelp from '../../../../Components/IconSetter/ModalIconHelp.vue';
import IconSetter from '../../../../Components/IconSetter/IconSetter.vue';
import SortableList from '../../../../Components/List/Sortable/SortableList.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ButtonConfirmationUi, SelectForm, TextAreaForm, EditorTiny, ImagePreviewUi, ModalImagesList, AccordionGroup, AccordionItem, ModalUi, CardUi, TabpanelUi, TabNavItem, TabContent, ModalIcons, ModalIconHelp, IconSetter, SortableList },
    props: {
        section: { type: Object, default: {} },
        bindables: { type: Object, default: {} },
        sectionTypes: { type: Object, default: {} },
        terms: { type: Object, default: {} },
        tinyApiKey: { type: String, default: null },
    },

    data() {
        return {
            form: useForm({
                id: null,
                type: 'default',
                name: null,
                title: null,
                subtitle: null,
                content: null,
                buttons: [],
                bindable_class: null,
                visible: false,
                images: [],
                images_settings: [],
            }),

            tinyEditor: null,
            tinyEditorError: null,

            showImagesModalList: false,
            insertImageOn: null,

            showHowItWorkModal: false,

            showModalIconsHelp: false,
            showIconsModal: false,

            buttonIndex: -1,
        };
    },

    watch: {
        form: {
            deep: true,
            handler(nv) {
                let errors = nv.errors;

                this.tinyEditorError = errors?.content;
            }
        }
    },

    created() {
        if (!this.section?.id) return;

        this.form.id = this.section.id;
        this.form.type = this.section.type;
        this.form.name = this.section.name;
        this.form.title = this.section.title;
        this.form.subtitle = this.section.subtitle;
        this.tinyEditor = this.section.content;
        this.form.buttons = this.section.buttons;
        this.form.bindable_class = this.section.bindable_class;
        this.form.visible = this.section.visible;

        // image/images
        if (["default", "banner"].includes(this.section.type)) {
            this.form.images = this.section.images ?? [];
        }
    },

    methods: {
        submit() {
            let action = route("admin.sections.store");

            if (["default", "banner"].includes(this.form.type))
                this.form.content = this.tinyEditor;

            if (this.form?.id) {
                action = route('admin.sections.update', { section: this.section.id });
                this.form.put(action);
            } else {
                this.form.post(action);
            }
        },

        /**
         * start images modal
         */
        modalImagesListShow(event) {
            this.showImagesModalList = true;

            if (["default", "banner"].includes(this.form.type)) {
                this.insertImageOn = event.target.getAttribute("data-item");
            }
        },

        modalImagesListClose() {
            this.showImagesModalList = false;
        },

        insertImage(data) {
            if (["default", "banner"].includes(this.form.type)) {
                this.form.images[this.insertImageOn].id = data.id;
                this.form.images[this.insertImageOn].url = data.thumb_small;
            }
        },
        /**
         * end images modal
         */

        /**
         * start images
         */
        addNewImage() {
            this.form.images.push({
                id: null,
                duration: 2000,
                url: null
            });
        },
        removeImage(event) {
            let index = event.path[2].getAttribute("data-item");
            if (!index) return;

            this.form.images.splice(index, 1);
        },
        /**
         * end images
         */

        /**
         * start button
         */
        addNewButton() {
            let index = this.form.buttons.length + 1;

            this.form.buttons.unshift({
                text: "Link text #" + index,
                url: "#" + index,
                target: "_self",
                title: "Link title #" + index,
                icon: {
                    source: "local",
                    class: null,
                    name: null,
                    position: "start",
                },
                style: "primary",
            });
        },
        /**
         * end button
         */

        /**
         * start icon
         */
        showIconModalAndUpdateLinkIndexUnderEdit(event) {
            this.showIconsModal = true;
            this.buttonIndex = parseInt(event.path[5].getAttribute("data-index"));
        },

        iconHasChoosed(icon) {
            this.showIconsModal = false;
            this.form.buttons[this.buttonIndex].icon.class = icon.class;
            this.form.buttons[this.buttonIndex].icon.name = icon.name;
        },
        /**
         * end icon
         */
    },

    computed: {
        buttonsOrder() {
            let numbers = Object.keys(new Array(this.form.buttons.length).fill(null)).map(Number);
            let options = numbers.map((item) => {
                return {
                    text: item + 1,
                    value: item
                };
            });
            return options;
        },

        sectionTypesOptions() {
            let types = (Object.values(this.sectionTypes)).map((item) => {
                return {
                    value: item,
                    text: `${this.terms.type['type_' + item]}`
                };
            });
            return types;
        },

        showBindablesField() {
            return ["bindable"].includes(this.form.type);
        },

        showSlideIntervalField() {
            return ["default", "banner"].includes(this.form.type);
        },

        bindablesOptions() {
            let bindablesList = Object.entries(this.bindables);

            let unified = bindablesList.map((item) => {
                return {
                    text: this.terms.bindable[item[0]],
                    value: item[0]
                };
            });

            return unified;
        }
    }
}

</script>