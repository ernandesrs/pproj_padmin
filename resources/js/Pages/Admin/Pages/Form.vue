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

                    <div class="col-6 mb-4">
                        <SelectForm label="Tipo:" name="type" :options="[
                            {
                                value: 'view',
                                text: 'Customizada'
                            },
                            {
                                value: 'text',
                                text: 'Texto'
                            }
                        ]" v-model="form.type" :error-message="form.errors.type" />
                    </div>

                    <div class="col-6 mb-4 d-flex align-items-center">
                        <InputForm type="checkbox"
                            label="Permitir indexação aos mecanismos de busca"
                            name="follow" v-model="form.follow"
                            :error-message="form.errors.follow" />
                    </div>

                    <div class="col-12">
                        <EditorTiny v-model="form.content" />
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-4">
            </div>

            <div class="col-12 mb-4 text-center">
                <ButtonUi type="submit" icon="checkLg" variant="primary"
                    :text="`${page?.id ? 'Atualizar' : 'Salvar'}`" />
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
        page: { type: Object, default: [] },
        terms: { type: Object, default: {} },
    },

    data() {
        return {
            form: useForm({
                title: null,
                description: null,
                type: 'text',
                follow: null,
                content: ''
            })
        };
    },

    methods: {
        submit() {
            console.log(this.form.content);
        }
    }
};

</script>