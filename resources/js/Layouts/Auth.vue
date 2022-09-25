<template>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 col-xl-5 py-4 bg-primary"></div>
            <div class="col-12 col-lg-6 col-xl-7 py-4 px-5">
                <div class="d-flex justify-content-end mb-4">
                    <Link class="px-3 py-2 rounded" href="/">
                    Início
                    </Link>
                    <span class="ms-auto"></span>
                    <Link v-for="nav in navs" v-bind:key="nav.url"
                        :class="['px-3 py-2 rounded', {'bg-primary text-light': $page.url == nav.url}]"
                        :href="nav.url">
                    {{ nav.text }}
                    </Link>
                </div>
                <div class="card card-body border-0">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>

import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link,
    },
    data() {
        return {
            navs: [
                {
                    text: 'Login',
                    url: '/auth/login',
                },
                {
                    text: 'Cadastro',
                    url: '/auth/register',
                },
            ],
        };
    },
}

</script>
