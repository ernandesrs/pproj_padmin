<template>

    <EmptyList :show="!images?.data?.length" :is-filter="isFiltering" />

    <div class="row justify-content-center">
        <div v-for="image in images?.data" :key="image.id"
            class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <CardUi>
                <template v-slot:content>
                    <div
                        class="d-flex flex-column justify-content-center align-items-center">
                        <ImagePreviewUi :preview-url="image.thumb_small"
                            :preview-alt="image.name" borderless />
                        <div class="text-center pt-2">
                            <h2 class="fs-6 fw-semibold text-muted mb-0">
                                <a :href="image.path_url" target="_blank"
                                    title="Visualizar original">
                                    {{ `${$helpers.string.substr(image.name, 15)}` }}
                                </a>
                            </h2>
                            <small class="text-muted">
                                <p class="mb-0">
                                    <strong>Tam:</strong> <span>{{ (image.size /
                                    1000000).toFixed(3) }} Mb</span>
                                </p>
                                <p class="mb-0">
                                    {{ image.references }} referência{{
                                        image.references >
                                            1 ? 's' : ''
                                    }}
                                </p>
                            </small>
                        </div>
                        <div class="d-flex justify-content-center pt-1">
                            <ButtonUi size="sm" variant="info" icon="eye"
                                class="mx-1 my-1" :href="image.path_url"
                                target="_blank" />
                            <ButtonUi v-if="image.can.update" size="sm" variant="primary"
                                icon="pencilSquare" class="mx-1 my-1"
                                :to="$route('admin.medias.images.edit', { image: image.id })" />
                            <ButtonConfirmationUi v-if="image.can.delete"
                                confirm-text="Excluir?" size="sm" variant="danger"
                                icon="trash" position="center" class="mx-1 my-1"
                                :data-action="$route('admin.medias.images.destroy', { image: image.id })"
                                confirm-with-request request-method="delete" outlined />
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
import PaginationUi from '../../../../Components/List/PaginationUi.vue';
import EmptyList from '../../../../Components/List/EmptyList.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../../Components/Ui/ButtonConfirmationUi.vue';
import InputForm from '../../../../Components/Form/InputForm.vue';
import ModalUi from '../../../../Components/Ui/ModalUi.vue';
import ImagePreviewUi from '../../../../Components/Ui/ImagePreviewUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { PaginationUi, EmptyList, CardUi, ButtonUi, ButtonConfirmationUi, InputForm, ModalUi, ImagePreviewUi },

    props: {
        images: { type: Object, default: [] },
        terms: { type: Object, default: {} },
        isFiltering: { type: Boolean, default: false },
    },
}

</script>