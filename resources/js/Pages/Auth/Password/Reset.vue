<template>

    <form @submit.prevent="submit">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 mb-4">
                <InputForm label="Senha" type="password" name="password"
                    :error-message="form.errors.password" v-model="form.password" />
            </div>
            <div class="col-12 col-md-10 col-lg-8 mb-4">
                <InputForm label="Confirme a senha" type="password"
                    name="password_confirmation"
                    :error-message="form.errors.password_confirmation"
                    v-model="form.password_confirmation" />
            </div>

            <div
                class="col-12 col-md-10 col-lg-8 mb-4 d-flex align-items-center justify-content-center">
                <ButtonUi text="Atualizar senha" type="submit" variant="primary"
                    icon="checkLg" :disabled="form.processing" />
            </div>
        </div>
    </form>

</template>
  
<script>

import { useForm } from '@inertiajs/inertia-vue3';
import Layout from './../../../Layouts/Auth.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import InputForm from '../../../Components/Form/InputForm.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { useForm, ButtonUi, InputForm },
    props: {
        email: { type: String, default: null },
        token: { type: String, default: null }
    },

    setup(props) {
        const form = useForm({
            email: null,
            token: null,
            password: null,
            password_confirmation: null,
        });

        function submit() {
            form.transform((data) => ({
                ...data,
                email: props.email,
                token: props.token
            })).post(route("auth.resetPassword"));
        }

        return { form, submit };
    },

}
</script>