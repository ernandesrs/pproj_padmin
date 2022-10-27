<template>

    <form @submit.prevent="submit">
        <div class="card card-body border-0">
            <div class="row justify-content-center px-lg-5">
                <div v-if="video?.id"
                    class="col-12 col-md-10 col-lg-8 col-xl-7 mb-4 text-center">
                    <ButtonUi size="sm" variant="info" icon="eye"
                        text="Previsualizar vídeo" class="mx-1 my-1" :href="video.url"
                        target="_blank" />
                </div>
                <div class="col-12 col-md-10 col-lg-8 col-xl-7 mb-4">
                    <InputForm type="text" name="name" v-model="form.name" label="Nome"
                        :error-message="form.errors.name" />
                </div>
                <div class="col-12 col-md-10 col-lg-8 col-xl-7 mb-4">
                    <InputForm type="text" name="tags" v-model="form.tags" label="Tags"
                        :error-message="form.errors.tags" />
                </div>
                <div v-if="!video?.id" class="col-12 col-md-10 col-lg-8 col-xl-7 mb-4">
                    <InputForm @update:modelValue="form.file = $event.target.files[0]"
                        label="Vídeo" type="file" name="file"
                        :error-message="form.errors.file" />
                    <progress v-if="form.progress" :value="form.progress.percentage"
                        max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                </div>
                <div class="col-12 text-center">
                    <ButtonUi type="submit" variant="primary"
                        :text="`${video?.id ? 'Atualizar' : 'Enviar'}`" icon="arrowUp"
                        :disabled="form.processing" />
                </div>
            </div>
        </div>
    </form>

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import PaginationUi from '../../../../Components/PaginationUi.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import InputForm from '../../../../Components/Form/InputForm.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { PaginationUi, InputForm, ButtonUi },
    props: {
        video: { type: Object, default: {} }
    },

    data() {
        return {
            form: useForm({
                name: null,
                tags: null,
                file: null,
            })
        };
    },

    mounted() {
        if (!this.video?.id) return;

        this.form.name = this.video.name;
        this.form.tags = this.video.tags;
    },

    methods: {
        submit() {
            let action = route("admin.medias.videos.store");
            if (this.video?.id)
                action = route("admin.medias.videos.update", { video: this.video?.id });

            this.form.post(action);
        }
    }
}

</script>