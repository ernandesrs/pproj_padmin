<template>

    <Head title='Acessar conta' />

    <form @submit.prevent="submit">
        <div class="flex flex-col">
            <div class="flex flex-col mb-3">
                <label for="email">Email:</label>
                <input class="border py-1 px-3" id="email" v-model="form.email" />
                <div v-if="form.errors.email" class="text-red-700">
                    {{form.errors.email}}
                </div>
            </div>

            <div class="flex flex-col mb-6">
                <label for="password">Senha:</label>
                <input class="border py-1 px-3" type="password" id="password"
                    v-model="form.password" />
                <div v-if="form.errors.password" class="text-red-700">
                    {{form.errors.password}}
                </div>
            </div>

            <div>
                <ButtonUi text="Login" type="submit" :disabled="form.processing" />
            </div>
        </div>
    </form>

</template>
  
<script>

import Layout from './../../Layouts/Auth.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import ButtonUi from '../../components/Ui/ButtonUi.vue';

export default {
    components: { Head, useForm, ButtonUi },
    layout: (h, page) => h(Layout, () => child), // Using a render function
    layout: Layout, // Using the shorthand

    setup() {
        const form = useForm({
            email: null,
            password: null,
        })

        function submit() {
            form.post("/auth/login", {
                onError: () => {
                    console.log("Erro!");
                },
                onSuccess: () => {
                    console.log("Sucesso!");
                }
            });
        }

        return { form, submit }
    },

    props: {
        user: Object,
    },

}
</script>