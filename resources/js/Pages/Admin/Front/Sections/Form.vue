<template>

    <form @submit.prevent="submit">
        <div class="card card-body border-0">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-5 mb-4">
                    <div class="mb-4">
                        <InputForm type="text" name="name" v-model="form.name"
                            label="Nome da seção:" :error-message="form.errors.name" />
                    </div>
                </div>

                <div class="col-12 col-md-10 col-lg-7 mb-4">
                </div>

                <div class="col-12 text-center">
                    <ButtonUi type="submit" variant="primary"
                        :text="`${section.id ? 'Atualizar seção' : 'Salvar seção'}`"
                        icon="checkLg" :disabled="form.processing" />
                </div>
            </div>
        </div>
    </form>

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import InputForm from '../../../../Components/Form/InputForm.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../../Components/Ui/ButtonConfirmationUi.vue';
import SelectForm from '../../../../Components/Form/SelectForm.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ButtonConfirmationUi, SelectForm },
    props: {
        section: { type: Object, default: {} }
    },

    data() {
        return {
            form: useForm({
                id: null,
                name: null
            }),
        };
    },

    mounted() {
        if (!this.section?.id) return;

        this.form.id = this.section.id;
        this.form.name = this.section.name;
    },

    methods: {
        submit() {
            let action = route("admin.sections.store");

            if (this.form?.id)
                action = route('admin.sections.update', { section: this.section.id });

            this.form.post(action);
        },
    }
}

</script>