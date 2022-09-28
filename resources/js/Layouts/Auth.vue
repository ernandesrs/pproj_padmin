<template>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-5 col-xl-5 py-4 bg-primary"></div>
            <div class="col-12 col-lg-7 col-xl-7 py-4 px-5">
                <div class="d-flex justify-content-end mb-4">
                    <Link
                        :class="['px-3 py-2 rounded me-auto', {'bg-primary text-light': $route().current() == 'front.index'}]"
                        :href="$route('front.index')">
                    Início
                    </Link>
                    <Link v-for="nav in navs" v-bind:key="nav.url"
                        :class="['px-3 py-2 rounded', {'bg-primary text-light': nav.activeIn.includes($route().current())}]"
                        :href="nav.url">
                    {{ nav.text }}
                    </Link>
                </div>

                <AlertUi ref="alert" />

                <div class="card card-body border-0">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>

import { Link } from '@inertiajs/inertia-vue3'
import AlertUi from '../Components/Ui/AlertUi.vue';

export default {
    components: {
        Link,
        AlertUi
    },
    data() {
        return {
            navs: [
                {
                    text: 'Login',
                    url: this.$route("auth.login"),
                    activeIn: ['auth.login']
                },
                {
                    text: 'Cadastro',
                    url: this.$route("auth.register"),
                    activeIn: ['auth.register']
                },
            ],
        };
    },

    updated() {
        this.showFlashMessage();
    },

    methods: {
        showFlashMessage() {
            let flash = this.$page.props.flash;

            if (flash) {
                this.$refs.alert.add(flash.message, flash.variant);
            } else {
                this.$refs.alert.clear();
            }
        },
    }
}

</script>
