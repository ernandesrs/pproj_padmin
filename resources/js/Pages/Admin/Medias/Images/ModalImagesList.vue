<template>

    <ModalUi @modalClose="showModal = false" :show="showModal" size="lg" top full-height>
        <div class="d-flex mb-3">
            <ButtonUi @click="showImagesList" text="Lista de imagens"
                :variant="`${showImagesListTab ? 'primary' : null}`"
                :isActive="showImagesListTab" />
            <ButtonUi @click="showNewUpload" text="Novo upload"
                :variant="`${showNewUploadTab ? 'primary' : null}`"
                :isActive="showNewUploadTab" />
        </div>

        <div v-if="showImagesListTab" class="row">
            <div class="col-12 mb-3">
                <form @submit.prevent="search">
                    <div class="d-flex align-items-center">
                        <InputForm type="search" v-model="searchForm.search" />
                        <ButtonUi type="submit" icon="search" />
                    </div>
                </form>
            </div>

            <div v-if="!images?.data" class="col-12">
                <div class="card card-body position-relative">
                    <BackdropUi text-loading="Carregando imagens..." loading light />
                </div>
            </div>

            <div v-else v-for="image in images?.data" :key="image.id"
                class="col-6 col-sm-4 col-md-3 text-center mb-4">
                <CardUi>
                    <template v-slot:content>
                        <ImagePreviewUi :preview-url="image.thumb_small"
                            :preview-alt="image.name" borderless @click="insertImage"
                            :data-info="`${JSON.stringify({
                                id: image.id,
                                url: image.path_url,
                                thumb_small: image.thumb_small
                            })}`" style="cursor:pointer;" />

                        <p class="mb-0 fs-6 fw-semibold text-muted text-center py-1">
                            {{ $helpers.string.substr(image.name, 10) }}
                        </p>
                    </template>
                </CardUi>
            </div>

            <PaginationUi v-if="images?.data" :pages="images?.meta?.links"
                url-params="onlyList=1" />
        </div>

        <div v-else>
            <form @submit.prevent="uploadImage">
                <div class="card card-body border-0">
                    <div class="row justify-content-center px-lg-5">
                        <div class="col-12 col-md-10 col-lg-8 col-xl-7 mb-4">
                            <InputForm type="text" name="name" v-model="uploadForm.name"
                                label="Nome:" :error-message="uploadForm.errors.name" />
                        </div>
                        <div class="col-12 col-md-10 col-lg-8 col-xl-7 mb-4">
                            <InputForm type="text" name="tags" v-model="uploadForm.tags"
                                label="Tags:" :error-message="uploadForm.errors.tags" />
                        </div>
                        <div class="col-12 col-md-10 col-lg-8 col-xl-7 mb-4">
                            <InputForm
                                @update:modelValue="uploadForm.file = $event.target.files[0]"
                                label="Imagem:" type="file" name="file"
                                :error-message="uploadForm.errors.file" />
                            <progress v-if="uploadForm.progress"
                                :value="uploadForm.progress.percentage" max="100">
                                {{ uploadForm.progress.percentage }}%
                            </progress>
                        </div>
                        <div class="col-12 text-center">
                            <ButtonUi type="submit" variant="primary" text="Enviar"
                                icon="arrowUp" :disabled="uploadForm.processing" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </ModalUi>

</template>

<script>

import ModalUi from '../../../../Components/Ui/ModalUi.vue';
import InputForm from '../../../../Components/Form/InputForm.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import BackdropUi from '../../../../Components/Ui/BackdropUi.vue';
import PaginationUi from '../../../../Components/PaginationUi.vue';
import ImagePreviewUi from '../../../../Components/Ui/ImagePreviewUi.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';

export default {
    components: { ModalUi, InputForm, ButtonUi, BackdropUi, PaginationUi, ImagePreviewUi, CardUi },

    props: {
        show: { type: Boolean, default: false },
    },

    data() {
        return {
            uploadForm: useForm({
                name: null,
                tags: null,
                file: null
            }),
            searchForm: useForm({
                search: null,
                filter: 1,
                onlyList: 1
            }),
            showModal: false,
            showImagesListTab: true,
            showNewUploadTab: false,
            images: {}
        };
    },

    beforeMount() {
        if (this.$page.props.images?.data) {
            this.images = this.$page.props.images;

            if (!this.showModal)
                this.showModal = true;
        }
    },

    watch: {
        show: {
            immediate: true,
            handler(nv) {
                if (nv) {
                    this.showModal = true;
                    this.getImages();
                }
            },
        }
    },

    methods: {
        getImages(force = false) {
            if (this.images?.data && !force) return;
            Inertia.visit(route("admin.medias.images.index", { onlyList: 1 }), {
                only: ["images"]
            });
        },

        search() {
            Inertia.visit(route("admin.medias.images.index", { onlyList: 1 }), {
                data: {
                    search: this.searchForm.search,
                    filter: this.searchForm.filter,
                    onlyList: this.searchForm.onlyList
                },
                only: ["images"]
            });
        },

        insertImage(event) {
            let data = JSON.parse(event.target.getAttribute("data-info"));

            if (!data?.id) return;

            this.$emit("imageInsert", data);

            this.showModal = false;
        },

        uploadImage() {
            let action = this.$route('admin.medias.images.upload');

            this.uploadForm.post(action, {
                onSuccess: (r) => {
                    this.showImagesList();
                    this.getImages(true);
                }
            });
        },

        showImagesList() {
            this.showImagesListTab = true;
            this.showNewUploadTab = false;
        },

        showNewUpload() {
            this.showNewUploadTab = true;
            this.showImagesListTab = false;
        }
    },
};

</script>