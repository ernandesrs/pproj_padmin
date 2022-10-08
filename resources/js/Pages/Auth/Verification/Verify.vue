<template>

    <div v-if="!auth?.id" class="text-center text-muted">
        <h1 class="fs-4 fw-semibold">Não verificado!</h1>
        <p class="fs-6">
            Você precisa estar logado para fazer a verificação da sua conta. Faça login e
            acesse novamento o link enviado para o seu email.
        </p>
        <Link class="btn btn-primary" :href="$route('auth.login')">
        Fazer login
        </Link>
    </div>
    <div v-else-if="hasError" class="text-center text-danger">
        <h1 class="fs-4 fw-semibold">Não verificado!</h1>
        <p class="fs-6">
            {{ auth.first_name }}, o link de verificação não possui um token válido!
        </p>
        <a @click.prevent="resend" class="btn btn-primary" href="#">
            Solicitar novo link
        </a>
    </div>
    <div v-else-if="hasSent" class="text-center text-success">
        <h1 class="fs-4">Link de verificação reenviado!</h1>
        <p>
            {{ auth.first_name }}, um novo link de verificação foi enviado para o endereço
            de e-mail cadastrado!
        </p>
    </div>
    <div v-else-if="hasVerified" class="text-center text-success">
        <h1 class="fs-4">Verificado com sucesso!</h1>
        <p>
            {{ auth.first_name }}, seu registro foi verificado com sucesso!
        </p>
    </div>
    <div v-else class="position-relative" style="height: 75px;">
        <BackdropUi text-loading="Aguarde, verificando conta..." loading light />
    </div>

</template>
  
<script>

import Layout from './../../../Layouts/Auth.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import BackdropUi from '../../../Components/Ui/BackdropUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { Link, BackdropUi },
    props: {
        token: '',
        auth: { type: Object, default: {} },
        hasError: { type: Boolean, default: false },
        hasVerified: { type: Boolean, default: false },
        hasSent: { type: Boolean, default: false },
    },

    mounted() {
        this.verify();
    },

    methods: {
        resend() {
            Inertia.post(route("auth.verificationResend"));
        },

        verify() {
            Inertia.post(route("auth.verifyRegister", {
                token: this.token
            }))
        }
    }
}
</script>