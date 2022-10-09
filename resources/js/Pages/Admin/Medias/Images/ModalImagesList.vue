<template>

    <ModalUi @modalClose="showModal = false" :show="showModal" size="lg" top>
        <div class="row pb-4">
            <div class="col-12 col-sm-7 col-lg-8">
                <h5 class="fw-semibold fs-5 text-muted">Imagens</h5>
            </div>

            <div class="col-12 col-sm-5 col-lg-4">
                <form @submit.prevent="search">
                    <div class="d-flex align-items-center">
                        <InputForm type="search" v-model="searchForm.search" />
                        <ButtonUi type="submit" icon="search" />
                    </div>
                </form>
            </div>
        </div>

        <div class="row py-2">
            <div v-if="!images?.data" class="col-12">
                <div class="card card-body position-relative">
                    <BackdropUi text-loading="Carregando imagens..." loading light />
                </div>
            </div>

            <div v-else v-for="image in images?.data" :key="image.id"
                class="col-6 col-sm-4 col-md-3 col-xl-2 text-center mb-4">
                <a :href="image.url" title="Ver imagem original" target="_blank">
                    <ImagePreviewUi :preview-url="image.thumb_small"
                        :preview-alt="image.name" borderless />

                    <p class="mb-0 fs-6 fw-semibold text-muted text-center py-1">
                        {{ $helpers.string.substr(image.name, 10) }}
                    </p>
                </a>
                <ButtonUi @click="insertImage" variant="dark" icon="checkLg"
                    text="Inserir" size="sm" :data-info="`${JSON.stringify({
                        id: image.id,
                        url: image.path_url,
                        thumb_small: image.thumb_small
                    })}`" />
            </div>

            <PaginationUi v-if="images?.data" :pages="images?.meta?.links"
                url-params="onlyList=1" />
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

export default {
    components: { ModalUi, InputForm, ButtonUi, BackdropUi, PaginationUi, ImagePreviewUi },
    props: {
        show: { type: Boolean, default: false },
    },
    data() {
        return {
            searchForm: useForm({
                search: null,
                filter: 1,
                onlyList: 1
            }),
            showModal: false,
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
        getImages() {
            if (this.images?.data) return;
            Inertia.get(route("admin.medias.images.index", { onlyList: 1 }));
        },
        search() {
            this.searchForm.get(route("admin.medias.images.index"));
        },
        insertImage(event) {
            let data = JSON.parse(event.target.getAttribute("data-info"));
            if (!data?.id) return;

            this.$emit("imageInsert", data);

            this.showModal = false;
        }
    },
};

</script>