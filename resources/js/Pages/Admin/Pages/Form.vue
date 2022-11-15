<template>

    <ModalImagesList :show="showImagesModalList" @modalClose="modalImagesListClose"
        @imageInsert="insertImage" />

    <form @submit.prevent="submit">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 mb-4">
                <div class="row">
                    <div class="col-12 mb-4">
                        <InputForm type="text" label="Título:" name="title"
                            v-model="form.title" :error-message="form.errors.title" />
                    </div>

                    <div class="col-12 mb-4">
                        <TextAreaForm label="Descrição:" name="description"
                            v-model="form.description"
                            :error-message="form.errors.description" rows="3" />
                    </div>

                    <div v-if="form.content_type == 1" class="col-12 mb-4">
                        <label class="mb-1">Conteúdo:</label>
                        <EditorTiny v-model="form.content" :api-key="tinyApiKey" />
                    </div>

                    <div v-else-if="form.content_type == 2" class="col-12 mb-4">
                        <InputForm label="Página customizada:" name="view_path"
                            v-model="form.view_path"
                            :error-message="form.errors.view_path"
                            :disabled="page.protection == 9" />
                        <div v-if="page?.id && page.content_type == 1 && form.content_type == 2"
                            class="mt-2">
                            <p class="mb-0 alert alert-warning text-center">
                                <small><b>Atenção:</b> ao atualizar você perderá
                                    completamente o conteúdo
                                    da página, tenha certeza de que é isso que você
                                    quer. Ou volte o 'tipo de página' para 'texto' antes
                                    de atualizar para manter o conteúdo.</small>
                            </p>
                        </div>
                    </div>

                    <div v-else class="col-12 mb-4">
                        <div class="border px-5 py-2 text-center">
                            Escolha um tipo de conteúdo.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-4">
                <div class="row">
                    <div
                        class="col-12 mb-4 d-flex flex-column justify-content-center align-items-center">
                        <ImagePreviewUi :preview-url="coverPreview"
                            :borderless="coverPreview ? true : false" />
                    </div>

                    <!-- cover upload -->
                    <div class="col-12 text-center mb-4">
                        <ButtonUi @click="modalImagesListShow"
                            :text="`${coverPreview ? 'Atualizar capa' : 'Inserir capa'}`"
                            icon="image" variant="success" size="sm" />
                    </div>

                    <div class="col-12 mb-4">
                        <SelectForm label="Tipo de página:" name="type" :options="[
                            {
                                value: 1,
                                text: 'Texto'
                            },
                            {
                                value: 2,
                                text: 'Customizada'
                            }
                        ]" v-model="form.content_type"
                            :error-message="form.errors.content_type"
                            :disabled="page.protection == 9" />
                    </div>

                    <div class="col-12 mb-4 d-flex align-items-center">
                        <InputForm type="checkbox"
                            label="Permitir indexação aos mecanismos de busca"
                            name="follow" v-model="form.follow"
                            :error-message="form.errors.follow"
                            :disabled="page.protection == 9" />
                    </div>

                    <div class="col-12 mb-4">
                        <SelectForm label="Salvar como:" :options="[
                            {
                                value: 1,
                                text: `${terms.status[('status_' + 1)]}`
                            },
                            {
                                value: 2,
                                text: `${terms.status[('status_' + 2)]}`
                            },
                            {
                                value: 3,
                                text: `${terms.status[('status_' + 3)]}`
                            }
                        ]" v-model="form.status" :disabled="page.protection == 9" />
                    </div>

                    <div v-if="form.status == 2" class="col-12 mb-4">
                        <InputForm label="Agendar para:" type="date"
                            v-model="form.schedule_to"
                            :error-message="form.errors.schedule_to" />
                    </div>

                    <div v-if="!page?.id || page?.id && page.can.update"
                        class="col-12 mb-4 text-center">
                        <ButtonUi type="submit" icon="checkLg" variant="primary"
                            :text="`${page?.id ? 'Atualizar' : 'Salvar'}`"
                            :disabled="form.processing" />
                    </div>
                </div>
            </div>
        </div>
    </form>

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import InputForm from '../../../Components/Form/InputForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import SelectForm from '../../../Components/Form/SelectForm.vue';
import EditorTiny from '../../../Components/EditorTiny.vue';
import ModalImagesList from '../Medias/Images/ModalImagesList.vue';
import ImagePreviewUi from '../../../Components/Ui/ImagePreviewUi.vue';
import TextAreaForm from '../../../Components/Form/TextAreaForm.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, SelectForm, EditorTiny, ModalImagesList, ImagePreviewUi, TextAreaForm },
    props: {
        page: { type: Object, default: {} },
        terms: { type: Object, default: {} },
        tinyApiKey: { type: String, default: null }
    },

    data() {
        return {
            form: useForm({
                id: null,
                title: null,
                description: null,
                content_type: 1,
                follow: false,
                content: null,
                view_path: null,
                status: 1,
                schedule_to: null,
                cover: null,
            }),
            showImagesModalList: false,
            coverPreview: null
        };
    },
    created() {
        this.setPageContentOnForm();
    },
    methods: {
        submit() {
            let action = route("admin.pages.store");

            if (this.page?.id) {
                action = route("admin.pages.update", { page: this.page.id });
                this.form.put(action);
            } else {
                this.form.post(action);
            }
        },

        setPageContentOnForm() {
            if (!this.page?.id) return;

            this.coverPreview = this.page?.thumb_small;

            this.form.id = this.page.id;
            this.form.title = this.page.title;
            this.form.description = this.page.description;
            this.form.content_type = this.page.content_type;
            this.form.follow = this.page.follow;
            this.form.content = this.page.content;
            this.form.view_path = this.page.view_path;
            this.form.status = this.page.status;

            this.form.schedule_to = this.page.schedule_to ? new Date(this.page.schedule_to).toISOString().slice(0, 10) : null;
        },

        modalImagesListShow() {
            this.showImagesModalList = true;
        },

        modalImagesListClose() {
            this.showImagesModalList = false;
        },

        insertImage(data) {
            this.coverPreview = data.thumb_small;
            this.form.cover = data.id;
        }
    }
};

</script>