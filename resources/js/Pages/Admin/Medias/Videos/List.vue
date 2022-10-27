<template>

    <EmptyList :show="!videos?.data?.length" :is-filter="isFiltering" />

    <div class="row justify-content-center">
        <div v-for="video in videos?.data" :key="video.id"
            class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <CardUi>
                <template v-slot:content>
                    <div
                        class="d-flex flex-column justify-content-center align-items-center">
                        <div class="text-center pt-2">
                            <h2 class="fs-6 fw-semibold text-muted mb-0">
                                {{ `${$helpers.string.substr(video.name, 15)}` }}
                            </h2>
                            <small class="text-muted">
                                <p class="mb-0">
                                    <strong>Tam:</strong> <span>{{ (video.size /
                                            1000000).toFixed(3)
                                    }} Mb</span>
                                </p>
                            </small>
                        </div>
                        <div class="d-flex justify-content-center pt-1">
                            <ButtonUi size="sm" variant="info" icon="eye"
                                class="mx-1 my-1" :href="video.url" target="_blank" />
                            <ButtonUi v-if="video.can.update" size="sm" variant="primary"
                                icon="pencilSquare" class="mx-1 my-1"
                                :to="$route('admin.medias.videos.edit', { video: video.id })" />
                            <ButtonConfirmationUi v-if="video.can.delete"
                                confirm-text="Excluir?" size="sm" variant="danger"
                                icon="trash" position="center" class="mx-1 my-1"
                                :data-action="$route('admin.medias.videos.destroy', { video: video.id })"
                                confirm-with-request outlined />
                        </div>
                    </div>
                </template>
            </CardUi>
        </div>
    </div>

    <PaginationUi label="Paginação de vídeos" :pages="videos?.meta?.links" />

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import PaginationUi from '../../../../Components/PaginationUi.vue';
import EmptyList from '../../../../Components/EmptyList.vue';
import CardUi from '../../../../Components/Ui/CardUi.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../../Components/Ui/ButtonConfirmationUi.vue';
import ImagePreviewUi from '../../../../Components/Ui/ImagePreviewUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { PaginationUi, EmptyList, CardUi, ButtonUi, ButtonConfirmationUi, ImagePreviewUi },

    props: {
        videos: { type: Object, default: [] },
        terms: { type: Object, default: {} },
        isFiltering: { type: Boolean, default: false },
    },

    data() {
        return {
        };
    },

    methods: {
    },

    computed: {
    }
}

</script>