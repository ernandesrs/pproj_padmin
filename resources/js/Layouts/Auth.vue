<template>

    <Head :title="`${appName} - ${pageTitle}`" />

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-5 col-xl-5"></div>
            <div class="col-12 col-lg-7 col-xl-7">
                <AlertUi :variant="flash?.variant" :message="flash?.message" />

                <h1 v-if="$page.props.pageTitle"
                    class="fs-4 fw-semibold text-center pt-1 pb-2">
                    {{ $page.props.pageTitle }}
                </h1>

                <div class="card card-body border-0 app-inner">
                    <slot />
                </div>

                <div class="text-center pt-3 pb-2">
                    <p v-if="['Auth/Register'].includes($page.component)" class="mb-0">
                        Caso possua uma conta,
                        <Link :href="$route('auth.login')">clique aqui para fazer
                        login</Link>.
                    </p>
                    <p v-if="['Auth/Login'].includes($page.component)" class="mb-0">
                        <Link :href="$route('auth.register')">Criar uma conta</Link>
                        ou
                        <Link :href="$route('auth.forget')">recuperar senha</Link>.
                    </p>
                    <p v-if="['Auth/Password/Forget'].includes($page.component)"
                        class="mb-0">
                        <Link :href="$route('auth.login')">Fazer login</Link>
                        ou
                        <Link :href="$route('auth.register')">criar conta</Link>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>

import { Head, Link } from '@inertiajs/inertia-vue3'
import AlertUi from '../Components/Ui/AlertUi.vue';

export default {
    components: { Head, Link, AlertUi },

    props: {
        auth: {},
        appName: { type: String, default: null },
        pageTitle: { type: String, default: null },
        flash: { type: Object, default: null }
    },

    data() {
        return {
        };
    },
}

</script>
