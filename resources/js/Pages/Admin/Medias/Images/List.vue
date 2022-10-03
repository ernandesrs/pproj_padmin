<template>

    <ModalUi @modalClose="modalClosed" :show="showModal">
        <form @submit.prevent="updateImage">
            <div class="mb-3 text-center">
                <img class="img-fluid" :src="image.thumb_small">
            </div>

            <div class="mb-3">
                <InputForm label="Nome:" type="text" v-model="updateForm.name"
                    :error-message="updateForm.errors.name" />
            </div>

            <div class="mb-3">
                <InputForm label="Tags:" type="text" v-model="updateForm.tags"
                    :error-message="updateForm.errors.tags" />
            </div>

            <div class="text-center">
                <ButtonUi type="submit" variant="primary" text="Atualizar" icon="checkLg"
                    :disabled="updateForm.processing" />
            </div>
        </form>
    </ModalUi>

    <EmptyList :show="!images?.data?.length" :is-filter="isFiltering" />

    <div class="row justify-content-center">
        <div v-for="image in images?.data" :key="image.id"
            class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <CardUi border>
                <template v-slot:content>
                    <div class="text-center">
                        <img class="img-fluid img-thumbnail" :src="image.thumb_small"
                            :alt="image.name">
                        <div class="text-center pt-2">
                            <h2 class="fs-6 fw-semibold text-muted mb-0">
                                <a :href="image.url" target="_blank"
                                    title="Visualizar original">
                                    {{ `${ image.name.substring(0, 15) }
                                    ${image.name.length > 15 ? '...' : ''}` }}
                                </a>
                            </h2>
                            <small class="text-muted">
                                <p class="mb-0">
                                    <strong>Tam:</strong> <span>{{ (image.size /
                                    1000000).toFixed(3) }} Mb</span>
                                </p>
                            </small>
                        </div>
                        <div class="d-flex justify-content-center pt-1">
                            <ButtonUi @click="getImageData" size="sm" variant="info"
                                icon="pencilSquare" class="mx-1 my-1"
                                :data-action="$route('admin.medias.images.show', {image: image.id})" />
                            <ButtonConfirmationUi confirm-text="Excluir?" size="sm"
                                variant="danger" icon="trash" position="center"
                                class="mx-1 my-1"
                                :data-action="$route('admin.medias.images.destroy', {image: image.id})"
                                confirm-with-request outlined />
                        </div>
                    </div>
                </template>
            </CardUi>
        </div>
    </div>

    <PaginationUi label="Paginação de imagens" :pages="images?.meta?.links" />

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import PaginationUi from '../../../../Components/PaginationUi.vue';
import EmptyList from '../../../../Components/EmptyList.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../../Components/Ui/ButtonConfirmationUi.vue';
import InputForm from '../../../../Components/Form/InputForm.vue';
import ModalUi from '../../../../Components/Ui/ModalUi.vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { PaginationUi, EmptyList, CardUi, ButtonUi, ButtonConfirmationUi, InputForm, ModalUi },

    props: {
        images: { type: Object, default: [] },
        image: { type: Object, default: {} },
        terms: { type: Object, default: {} },
        isFiltering: { type: Boolean, default: false },
    },

    data() {
        return {
            showModal: false,
            updateForm: useForm({
                name: null,
                tags: null
            })
        };
    },

    mounted() {
        this.showEditModal();
    },

    methods: {
        getImageData(e) {
            let action = e.target.getAttribute("data-action");

            Inertia.get(action);
        },

        showEditModal() {
            if (!this.image?.id) return;

            this.updateForm.name = this.image.name;
            this.updateForm.tags = this.image.tags;

            this.showModal = true;
        },

        updateImage() {
            // update
        },

        modalClosed() {
            this.showModal = false;
        }
    },

    computed: {
    }
}

</script>