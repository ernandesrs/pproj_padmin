<template>

    <div v-if="hasSent" class="text-center text-success">
        <h1>Link de recuperação enviado!</h1>
        <p>
            Uma mensagem com um link de recuperação foi enviado para o endereço de e-mail
            informado.
        </p>
    </div>
    <form v-else @submit.prevent="submit">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 mb-4">
                <InputForm label="E-mail" type="email" name="email"
                    :error-message="form.errors.email" v-model="form.email" />
            </div>

            <div
                class="col-12 col-md-10 col-lg-8 d-flex align-items-center justify-content-center">
                <ButtonUi text="Solicitar link" type="submit" variant="primary"
                    icon="checkLg" :disabled="form.processing" />
            </div>
        </div>

    </form>

</template>
  
<script>

import Layout from './../../../Layouts/Auth.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import InputForm from '../../../Components/Form/InputForm.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { useForm, ButtonUi, InputForm },
    props: {
        hasSent: false
    },

    setup() {
        const form = useForm({
            email: null,
        });

        function submit() {
            form.post(route("auth.forget"));
        }

        return { form, submit };
    },

}
</script>