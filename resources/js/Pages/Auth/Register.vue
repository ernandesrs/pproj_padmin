<template>

    <Head title='Criar uma conta' />

    <form @submit.prevent="submit">
        <div class="flex flex-col">
            <div class="flex flex-col mb-3">
                <label for="first_name">Nome:</label>
                <input class="border py-1 px-3" id="first_name"
                    v-model="form.first_name" />
                <div v-if="form.errors.first_name" class="text-red-700">
                    {{form.errors.first_name}}
                </div>
            </div>

            <div class="flex flex-col mb-3">
                <label for="last_name">Sobrenome:</label>
                <input class="border py-1 px-3" id="last_name" v-model="form.last_name" />
                <div v-if="form.errors.last_name" class="text-red-700">
                    {{form.errors.last_name}}
                </div>
            </div>

            <div class="flex flex-col mb-3">
                <label for="username">Usuário:</label>
                <input class="border py-1 px-3" id="username" v-model="form.username" />
                <div v-if="form.errors.username" class="text-red-700">
                    {{form.errors.username}}
                </div>
            </div>

            <div class="flex flex-col mb-3">
                <label for="gender">Gênero:</label>
                <select class="border py-1 px-3" id="gender" v-model="form.gender">
                    <option value="male">
                        Masculino
                    </option>
                    <option value="female">
                        Feminino
                    </option>
                </select>
                <div v-if="form.errors.gender" class="text-red-700">
                    {{form.errors.gender}}
                </div>
            </div>

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

            <div class="flex flex-col mb-6">
                <label for="password_confirmation">Confirmar senha:</label>
                <input class="border py-1 px-3" type="password" id="password_confirmation"
                    v-model="form.password_confirmation" />
                <div v-if="form.errors.password_confirmation" class="text-red-700">
                    {{form.errors.password_confirmation}}
                </div>
            </div>

            <div>
                <button
                    class="px-3 py-2 bg-blue-700 disabled:bg-blue-500 text-gray-200 disabled:text-gray-400"
                    type="submit" :disabled="form.processing">Cadastrar</button>
            </div>
        </div>
    </form>

</template>
  
<script>

import Layout from './../../Layouts/Auth.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

export default {
    components: { Head },
    layout: (h, page) => h(Layout, () => child), // Using a render function
    layout: Layout, // Using the shorthand

    setup() {
        const form = useForm({
            first_name: null,
            last_name: null,
            username: null,
            email: null,
            password: null,
            password_confirmation: null
        });

        function submit() {
            form.post("/auth/register", {
                onError: () => {
                    console.log("Erro!");
                },
                onSuccess: () => {
                    console.log("Sucesso!");
                }
            });
        }

        return { form, submit };
    },

    props: {
        user: Object,
    },
}
</script>