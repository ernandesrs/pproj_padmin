<template>

    <Head title='Verifique sua conta' />

    <div v-if="hasSent" class="text-center text-success">
        <h1>Link de verificação reenviado!</h1>
        <p>
            Um novo link de verificação foi enviado para o seu endereço de e-mail.
        </p>
    </div>
    <div v-else class="text-left text-muted">
        <h1 class="fs-3">Verifique seu e-mail!</h1>
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

import Layout from './../../../Layouts/Auth.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { Head },
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