<template>

    <form @submit.prevent="submit">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 mb-4">
                <InputForm label="E-mail" type="email" name="email"
                    :error-message="form.errors.email" v-model="form.email" />
            </div>

            <div class="col-12 col-md-10 col-lg-8 mb-4">
                <InputForm label="Senha" type="password" name="password"
                    :error-message="form.errors.password" v-model="form.password" />
            </div>

            <div class="col-12 col-md-10 col-lg-8 d-flex align-items-center">
                <InputForm label="Lembre-se de mim" type="checkbox" name="remember_me"
                    :error-message="form.errors.remember_me" v-model="form.remember_me"
                    inline />

                <span class="ms-auto"></span>
                <ButtonUi text="Login" type="submit" variant="primary" icon="login"
                    :disabled="form.processing" />
            </div>
        </div>

    </form>

</template>
  
<script>

import { useForm, Link } from '@inertiajs/inertia-vue3';
import Layout from './../../Layouts/Auth.vue';
import ButtonUi from '../../Components/Ui/ButtonUi.vue';
import InputForm from '../../Components/Form/InputForm.vue';

export default {
    components: { useForm, ButtonUi, InputForm, Link },
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    props: {
        user: Object,
        guest: Object,
    },

    setup() {
        const form = useForm({
            email: null,
            password: null,
            remember_me: null,

        });

        function submit() {
            form.post("/auth/login");
        }

        return { form, submit };
    },

    mounted() {
        if (this.guest) {
            this.form.email = this.guest.email;
            this.form.password = this.guest.password;
        }
    },
}
</script>