<template>

    <ModalImagesList :show="showImagesModalList" @modalClose="modalImagesListClose"
        @imageInsert="insertImage" />

    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-12 col-lg-4 mb-4">
                <div class="card card-body mb-4 h-100">
                    <h2 class="fs-5 fw-semibold">Cabeçalho</h2>
                    <div class="row">
                        <div class="col-6 mb-4 text-center">
                            <ImagePreviewUi :preview-url="faviconPreview"
                                preview-alt="Favicon preview"
                                :borderless="faviconPreview ? true : false"
                                class="mb-2" />

                            <ButtonUi @click="modalImagesListShow" text="Novo favicon"
                                icon="image" variant="success" size="sm"
                                data-to="favicon" />
                        </div>

                        <div class="col-6 mb-4 text-center">
                            <ImagePreviewUi :preview-url="logoPreview"
                                preview-alt="Logo preview"
                                :borderless="logoPreview ? true : false" class="mb-2" />

                            <ButtonUi @click="modalImagesListShow" text="Novo logo"
                                icon="image" variant="success" size="sm" data-to="logo" />
                        </div>

                        <div class="col-12">
                            <SelectForm label="Menu principal:" name="menu_main"
                                v-model="form.header.menu_main" :options="menus.map((menu) => {
                                    return {
                                        text: menu.name,
                                        value: menu.id
                                    };
                                })" :error-message="form.errors['header.menu_main']" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-4">
                <div class="card card-body mb- h-100">
                    <h2 class="fs-5 fw-semibold">Corpo</h2>
                    <p class="text-muted">
                        Crie seções em <strong>Seções</strong> >
                        <Link :href="$route('admin.sections.create')">
                        <strong>Nova seção</strong>
                        </Link> e defina abaixo quais delas serão exibidas.
                    </p>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <SelectForm label="Seção 1:" name="section_1"
                                v-model="form.home.section_1"
                                :options="sectionsOptions([2, 3])"
                                :error-message="form.errors['sections.section_1']" />
                        </div>
                        <div class="col-12 mb-4">
                            <SelectForm label="Seção 2:" name="section-2"
                                v-model="form.home.section_2"
                                :options="sectionsOptions([0, 1])"
                                :error-message="form.errors['sections.section_2']" />
                        </div>
                        <div class="col-12 mb-4">
                            <SelectForm label="Seção 3:" name="section_3"
                                v-model="form.home.section_3"
                                :options="sectionsOptions([4])"
                                :error-message="form.errors['sections.section_3']" />
                        </div>
                        <div class="col-12 mb-4">
                            <SelectForm label="Seção 4:" name="section_4"
                                v-model="form.home.section_4"
                                :options="sectionsOptions([0, 1])"
                                :error-message="form.errors['sections.section_4']" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-4">
                <div class="card card-body mb-4 h-100">
                    <h2 class="fs-5 fw-semibold">Rodapé</h2>
                    <div class="row">
                        <div class="col-12">
                            <SelectForm label="Menu rodapé:" name="menu_main"
                                v-model="form.footer.menu_main" :options="menus.map((menu) => {
                                    return {
                                        text: menu.name,
                                        value: menu.id
                                    };
                                })" :error-message="form.errors['footer.menu_main']" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <ButtonUi text="Atualizar" icon="checkLg" type="submit"
                    variant="primary" />
            </div>
        </div>
    </form>

</template>

<script>

import { Link, useForm } from '@inertiajs/inertia-vue3';
import Layout from './../../../Layouts/Panel.vue';
import InputForm from '../../../Components/Form/InputForm.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import ImagePreviewUi from '../../../Components/Ui/ImagePreviewUi.vue';
import ModalImagesList from '../Medias/Images/ModalImagesList.vue';
import TextAreaForm from '../../../Components/Form/TextAreaForm.vue';
import SelectForm from '../../../Components/Form/SelectForm.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ImagePreviewUi, ModalImagesList, TextAreaForm, SelectForm, Link },
    props: {
        settings: { type: Object, default: {} },
        menus: { type: Object, default: {} },
        terms: { type: Object, default: {} },
        sections: { type: Object, default: {} },
    },

    data() {
        return {
            faviconPreview: this.settings?.content?.header?.favicon_url ?? null,
            logoPreview: this.settings?.content?.header?.logo_url ?? null,
            form: useForm({
                header: {
                    favicon: null,
                    logo: null,
                    menu_main: this.settings?.content?.header?.menu_main ?? null,
                },
                home: {
                    section_1: this.settings?.content?.home?.section_1?.id ?? null,
                    section_2: this.settings?.content?.home?.section_2?.id ?? null,
                    section_3: this.settings?.content?.home?.section_3?.id ?? null,
                    section_4: this.settings?.content?.home?.section_4?.id ?? null,
                },
                footer: {
                    menu_main: this.settings?.content?.footer?.menu_main ?? null,
                }

            }),
            showImagesModalList: false,
            showImagesModalListTo: null
        };
    },

    methods: {
        submit() {
            if (this.form.header.menu_main == "none")
                this.form.header.menu_main = null;

            if (this.form.footer.menu_main == "none")
                this.form.footer.menu_main = null;

            this.form.post(route("admin.settings.update"));
        },

        modalImagesListShow(event) {
            this.showImagesModalListTo = event.target.getAttribute("data-to");
            this.showImagesModalList = true;
        },

        modalImagesListClose() {
            this.showImagesModalList = false;
        },

        insertImage(data) {
            if (this.showImagesModalListTo == 'favicon') {
                this.faviconPreview = data.url;
                this.form.header.favicon = data.id;
            } else {
                this.logoPreview = data.url;
                this.form.header.logo = data.id;
            }
        },

        sectionsOptions(allowedSectionTypes = []) {
            return this.sections.filter((section) => {
                return allowedSectionTypes.includes(section.type);
            }).map((section) => {
                return {
                    text: `${section.name}`,
                    value: section.id
                };
            });
        }
    }
}
</script>