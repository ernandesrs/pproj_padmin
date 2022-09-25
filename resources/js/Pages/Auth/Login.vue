<template>

    <Head title='Acessar conta' />

    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-12">
                <InputForm label="E-mail" type="email" :error-message="form.errors.email"
                    v-model="form.email" />
            </div>

            <div class="col-12">
                <InputForm label="Senha" type="password"
                    :error-message="form.errors.password" v-model="form.password" />
            </div>

            <div class="col-12 text-center">
                <ButtonUi text="Login" type="submit" :disabled="form.processing" />
            </div>
        </div>

    </form>

</template>
  
<script>

import Layout from './../../Layouts/Auth.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import ButtonUi from '../../components/Ui/ButtonUi.vue';
import InputForm from '../../components/Form/InputForm.vue';

export default {
    components: { Head, useForm, ButtonUi, InputForm },
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,

    setup() {
        const form = useForm({
            email: null,
            password: null,
        })

        function submit() {
            form.post("/auth/login", {
                onError: () => {
                    console.log("Erro!");
                },
                onSuccess: () => {
                    console.log("Sucesso!");
                }
            });
        }

        return { form, submit }
    },

    props: {
        user: Object,
    },

}
</script>