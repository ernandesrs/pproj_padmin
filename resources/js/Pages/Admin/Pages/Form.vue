<template>

    <form @submit.prevent="submit">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 mb-4">
                <div class="row">
                    <div class="col-12 mb-4">
                        <InputForm type="text" label="Título:" name="title"
                            v-model="form.title" :error-message="form.errors.title" />
                    </div>

                    <div class="col-12 mb-4">
                        <InputForm type="text" label="Descrição:" name="description"
                            v-model="form.description"
                            :error-message="form.errors.description" />
                    </div>

                    <div v-if="form.content_type == 1" class="col-12 mb-4">
                        <label class="mb-1">Conteúdo:</label>
                        <EditorTiny v-model="form.content" />
                    </div>

                    <div v-else-if="form.content_type == 2" class="col-12 mb-4">
                        <InputForm label="Página customizada:" name="view_path"
                            v-model="form.view_path"
                            :error-message="form.errors.view_path" />
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
                        <div class="border d-flex justify-content-center align-items-center mb-3"
                            style="width:100%;max-width:200px;height:100px;">
                            <img v-if="page.cover" :src="page.thumb_small"
                                :alt="page.title">
                            <span v-else class="text-muted">Preview</span>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <InputForm
                            @update:modelValue="form.cover = $event.target.files[0]"
                            label="Capa:" type="file" name="cover"
                            :error-message="form.errors.cover" />

                        <progress v-if="form.progress" :value="form.progress.percentage"
                            max="100">
                            {{ form.progress.percentage }}%
                        </progress>
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
                            :error-message="form.errors.content_type" />
                    </div>

                    <div class="col-12 mb-4 d-flex align-items-center">
                        <InputForm type="checkbox"
                            label="Permitir indexação aos mecanismos de busca"
                            name="follow" v-model="form.follow"
                            :error-message="form.errors.follow" />
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
                        ]" v-model="form.status" />
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

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, SelectForm, EditorTiny },
    props: {
        page: { type: Object, default: {} },
        terms: { type: Object, default: {} },
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
            })
        };
    },

    created() {
        this.setPageContentOnForm();
    },

    methods: {
        submit() {
            let action = this.page?.id ? route("admin.pages.update", { page: this.page.id }) : route("admin.pages.store");
            this.form.post(action)
        },

        setPageContentOnForm() {
            if (!this.page?.id) return;

            this.form.id = this.page.id;
            this.form.title = this.page.title;
            this.form.description = this.page.description;
            this.form.content_type = this.page.content_type;
            this.form.follow = this.page.follow;
            this.form.content = this.page.content;
            this.form.view_path = this.page.view_path;
            this.form.status = this.page.status;

            this.form.schedule_to = this.page.schedule_to ? new Date(this.page.schedule_to).toISOString().slice(0, 10) : null;
        }
    }
};

</script>