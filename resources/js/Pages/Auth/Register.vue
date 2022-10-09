<template>

    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <InputForm label="Nome" name="first_name" v-model="form.first_name"
                    :error-message="form.errors.first_name" />
            </div>

            <div class="col-12 col-md-6 mb-4">
                <InputForm label="Sobrenome" name="last_name" v-model="form.last_name"
                    :error-message="form.errors.last_name" />
            </div>

            <div class="col-12 col-sm-7 col-md-6 mb-4">
                <InputForm label="Usuário" name="username" v-model="form.username"
                    :error-message="form.errors.username" />
            </div>

            <div class="col-12 col-sm-5 col-md-6 mb-4">
                <SelectForm label="Gênero" name="gender" :options="[
                    {text: 'Não definir', value: 0},
                    {text: 'Masculino', value: 1},
                    {text: 'Feminino', value: 2},
                ]" v-model="form.gender" :error-message="form.errors.gender" />
            </div>

            <div class="col-12 mb-4">
                <InputForm label="Email" type="email" name="email" v-model="form.email"
                    :error-message="form.errors.email" />
            </div>

            <div class="col-12 col-md-6 mb-4">
                <InputForm label="Senha" type="password" name="password"
                    v-model="form.password" :error-message="form.errors.password" />
            </div>

            <div class="col-12 col-md-6 mb-4">
                <InputForm label="Confirmar senha" type="password"
                    name="password_confirmation" v-model="form.password_confirmation"
                    :error-message="form.errors.password_confirmation" />
            </div>

            <div class="col-12 text-center">
                <ButtonUi text="Cadastrar" type="submit" variant="primary" icon="checkLg"
                    :disabled="form.processing" />
            </div>
        </div>
    </form>

</template>
  
<script>

import Layout from './../../Layouts/Auth.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import ButtonUi from '../../Components/Ui/ButtonUi.vue';
import InputForm from '../../Components/Form/InputForm.vue';
import SelectForm from '../../Components/Form/SelectForm.vue';

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
            form.post("/auth/register");
        }

        return { form, submit };
    },

    props: {
        user: Object,
    },
}
</script>