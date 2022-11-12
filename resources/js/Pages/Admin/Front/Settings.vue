<template>

    <ModalImagesList :show="showImagesModalList" @modalClose="modalImagesListClose"
        @imageInsert="insertImage" />

    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card card-body mb-4">
                    <h2 class="fs-5 fw-semibold">Geral</h2>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <InputForm label="Título do site:" name="title"
                                v-model="form.title" :error-message="form.errors.title" />
                        </div>
                        <div class="col-12 mb-4">
                            <TextAreaForm label="Descrição do site:" name="description"
                                v-model="form.description"
                                :error-message="form.errors.description" rows="3" />
                        </div>
                        <div class="col-12">
                            <InputForm label="Permitir indexação aos mecanismos de buscas"
                                type="checkbox" name="follow" v-model="form.follow" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card card-body mb-4">
                    <h2 class="fs-5 fw-semibold">Cabeçalho</h2>
                    <div class="row mb-4">
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

                <div class="card card-body mb-4">
                    <h2 class="fs-5 fw-semibold">Rodapé</h2>
                    <div class="row mb-4">
                        <div class="col-6 mb-4 text-center">

                        </div>

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

import { useForm } from '@inertiajs/inertia-vue3';
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
    components: { InputForm, ButtonUi, ImagePreviewUi, ModalImagesList, TextAreaForm, SelectForm },
    props: {
        settings: { type: Object, default: {} },
        menus: { type: Object, default: {} },
    },

    data() {
        return {
            faviconPreview: this.settings?.content?.header?.favicon_url ?? null,
            logoPreview: this.settings?.content?.header?.logo_url ?? null,
            form: useForm({
                title: this.settings?.content?.title,
                description: this.settings?.content?.description,
                follow: this.settings?.content?.follow,
                header: {
                    favicon: null,
                    logo: null,
                    menu_main: this.settings?.content?.header?.menu_main ?? null,
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
    }
}
</script>