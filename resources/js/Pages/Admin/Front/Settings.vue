<template>


    <ModalImagesList :show="showImagesModalList" @modalClose="modalImagesListClose"
        @imageInsert="insertImage" />

    <section class="">
        <form @submit.prevent="submit">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-7 col-xl-8 mb-4">
                    <div class="col-12 mb-4">
                        <InputForm label="Título do site:" name="title"
                            v-model="form.title" :error-message="form.errors.title" />
                    </div>
                    <div class="col-12 mb-4">
                        <InputForm label="Descrição do site:" name="description"
                            v-model="form.description"
                            :error-message="form.errors.description" />
                    </div>
                    <div class="col-12 mb-4">
                        <InputForm label="Permitir indexação aos mecanismos de buscas"
                            type="checkbox" name="follow" v-model="form.follow" />
                    </div>
                </div>

                <div class="col-12 col-lg-5 col-xl-4 mb-4">
                    <div class="row">
                        <div class="col-6 text-center">
                            <ImagePreviewUi :preview-url="faviconPreview"
                                preview-alt="Favicon preview"
                                :borderless="faviconPreview ? true : false"
                                class="mb-2" />

                            <ButtonUi @click="modalImagesListShow" text="Novo favicon"
                                icon="image" variant="success" size="sm"
                                data-to="favicon" />
                        </div>
                        <div class="col-6 text-center">
                            <ImagePreviewUi :preview-url="logoPreview"
                                preview-alt="Logo preview"
                                :borderless="logoPreview ? true : false" class="mb-2" />

                            <ButtonUi @click="modalImagesListShow" text="Novo logo"
                                icon="image" variant="success" size="sm" data-to="logo" />
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <ButtonUi text="Atualizar" icon="checkLg" type="submit"
                        variant="primary" />
                </div>
            </div>
        </form>
    </section>

</template>

<script>

import { useForm } from '@inertiajs/inertia-vue3';
import Layout from './../../../Layouts/Panel.vue';
import InputForm from '../../../Components/Form/InputForm.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import ImagePreviewUi from '../../../Components/Ui/ImagePreviewUi.vue';
import ModalImagesList from '../Medias/Images/ModalImagesList.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ImagePreviewUi, ModalImagesList },
    props: {
        settings: { type: Object, default: {} }
    },

    data() {
        return {
            faviconPreview: this.settings?.favicon_url ?? null,
            logoPreview: this.settings?.logo_url ?? null,
            form: useForm({
                title: this.settings?.content?.title,
                description: this.settings?.content?.description,
                follow: this.settings?.content?.follow,
                favicon: null,
                logo: null,
            }),
            showImagesModalList: false,
            showImagesModalListTo: null
        };
    },

    methods: {
        submit() {
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
                this.form.favicon = data.id;
            } else {
                this.logoPreview = data.url;
                this.form.logo = data.id;
            }
        },
    }
}
</script>