<template>

    <Head title='Criar uma conta' />

    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-12 col-md-6">
                <InputForm label="Nome" name="first_name" v-model="form.first_name"
                    :error-message="form.errors.first_name" />
            </div>

            <div class="col-12 col-md-6">
                <InputForm label="Sobrenome" name="last_name" v-model="form.last_name"
                    :error-message="form.errors.last_name" />
            </div>

            <div class="col-12 col-md-6">
                <InputForm label="Usuário" name="username" v-model="form.username"
                    :error-message="form.errors.username" />
            </div>

            <div class="col-12 col-md-6">
                <SelectForm label="Gênero" name="gender" :options="[
                    {text: 'Masculino', value: 'male'},
                    {text: 'Feminino', value: 'female'},
                ]" v-model="form.gender" />
            </div>

            <div class="col-12">
                <InputForm label="Email" type="email" name="email" v-model="form.email"
                    :error-message="form.errors.email" />
            </div>

            <div class="col-12 col-md-6">
                <InputForm label="Senha" type="password" name="password"
                    v-model="form.password" :error-message="form.errors.password" />
            </div>

            <div class="col-12 col-md-6">
                <InputForm label="Confirmar senha" type="password"
                    name="password_confirmation" v-model="form.password_confirmation"
                    :error-message="form.errors.password_confirmation" />
            </div>

            <div class="col-12 text-center">
                <ButtonUi text="Cadastrar" type="submit" :disabled="form.processing" />
            </div>
        </div>
    </form>

</template>
  
<script>

import Layout from './../../Layouts/Auth.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import ButtonUi from '../../components/Ui/ButtonUi.vue';
import InputForm from '../../components/Form/InputForm.vue';
import SelectForm from '../../components/Form/SelectForm.vue';

export default {
    components: { Head, ButtonUi, InputForm, SelectForm },
    layout: (h, page) => h(Layout, () => child), // Using a render function
    layout: Layout, // Using the shorthand

    setup() {
        const form = useForm({
            first_name: null,
            last_name: null,
            username: null,
            gender: "none",
            email: null,
            password: null,
            password_confirmation: null
        });

        function submit() {
            form.post("/auth/register", {
                onError: () => {
                    console.log("Erro!");
                },
                onSuccess: () => {
                    console.log("Sucesso!");
                }
            });
        }

        return { form, submit };
    },

    props: {
        user: Object,
    },
}
</script>