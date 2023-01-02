<template>

    <div v-if="hasSent" class="text-center text-success">
        <h1>Link de verificação reenviado!</h1>
        <p>
            Um novo link de verificação foi enviado para o seu endereço de e-mail.
        </p>
    </div>
    <div v-else class="text-left text-muted">
        <h2 class="fs-5">Precisamos que você confirme a criação da sua conta!</h2>
        <p>
            Foi enviado um link de verificação para o e-mail informado
            no cadastro.
        </p>
        <a @click.prevent="resend" class="btn btn-outline-primary" href="#">Solicitar novo
            link</a>
    </div>

</template>
  
<script>

import { Inertia } from '@inertiajs/inertia';
import Layout from './../../../Layouts/Auth.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: {},
    props: {
        hasSent: false
    },

    methods: {
        resend() {
            Inertia.post(route("auth.verificationResend"));
        }
    }
}
</script>