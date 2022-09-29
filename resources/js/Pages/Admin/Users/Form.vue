<template>

    <div class="row justify-content-center">
        <div v-if="form?.id" class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="d-flex flex-column align-items-center">
                <img class="img-fluid rounded-circle" :src="user.thumb_normal" />
                <div class="py-3 text-center">
                    <p class="mb-0">
                        <strong>Registro:</strong> <span class="text-muted">{{
                        getDate(user.created_at) }}</span>
                    </p>
                    <p class="mb-0">
                        <span class="badge bg-primary">
                            Nível: {{ terms.user.level[user.level] }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <form @submit.prevent="submit">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <InputForm label="Nome" name="first_name"
                            v-model="form.first_name"
                            :error-message="form.errors.first_name" />
                    </div>

                    <div class="col-12 col-sm-6">
                        <InputForm label="Sobrenome" name="last_name"
                            v-model="form.last_name"
                            :error-message="form.errors.last_name" />
                    </div>

                    <div class="col-12 col-sm-7 col-md-6">
                        <InputForm label="Usuário" name="username" v-model="form.username"
                            :error-message="form.errors.username" />
                    </div>

                    <div class="col-12 col-sm-5 col-md-6">
                        <SelectForm label="Gênero" name="gender" :options="[
                            {text: 'Não definir', value: 0},
                            {text: 'Masculino', value: 1},
                            {text: 'Feminino', value: 2},
                        ]" v-model="form.gender" :error-message="form.errors.gender" />
                    </div>

                    <div class="col-12">
                        <InputForm label="Email" type="email" name="email"
                            v-model="form.email" :error-message="form.errors.email"
                            :disabled="form?.id ? true : false" />
                    </div>

                    <div v-if="form.id" class="col-12">
                        <InputForm
                            @update:modelValue="form.photo = $event.target.files[0]"
                            label="Foto" type="file" name="photo"
                            :error-message="form.errors.photo" />

                        <progress v-if="form.progress" :value="form.progress.percentage"
                            max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                    </div>

                    <div class="col-12 col-md-6">
                        <InputForm label="Senha" type="password" name="password"
                            v-model="form.password"
                            :error-message="form.errors.password" />
                    </div>

                    <div class="col-12 col-md-6">
                        <InputForm label="Confirmar senha" type="password"
                            name="password_confirmation"
                            v-model="form.password_confirmation"
                            :error-message="form.errors.password_confirmation" />
                    </div>

                    <div class="col-12 text-center">
                        <ButtonUi text="Cadastrar" type="submit" variant="primary"
                            icon="checkLg" :disabled="form.processing" />
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<script>

import { useForm } from '@inertiajs/inertia-vue3';
import Layout from './../../../Layouts/Panel.vue';
import InputForm from '../../../Components/Form/InputForm.vue';
import SelectForm from '../../../Components/Form/SelectForm.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';

export default {
    components: { InputForm, SelectForm, ButtonUi },
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    props: {
        user: {
            type: Object, default: {
                id: null,
                first_name: null,
                last_name: null,
                username: null,
                email: null,
                photo: null,
                gender: 'none',
                password: null,
                password_confirmation: null
            }
        }
    },

    data() {
        return {
            form: useForm({
                id: this.user?.id ?? null,
                first_name: this.user?.first_name ?? null,
                last_name: this.user?.last_name ?? null,
                username: this.user?.username ?? null,
                email: this.user?.email ?? null,
                photo: null,
                gender: this.user?.gender ?? 'none',
                password: null,
                password_confirmation: null
            }),

            terms: {
                user: {
                    level: {
                        1: 'Usuário',
                        5: 'Membro',
                        8: 'Administrador',
                        9: 'Super',
                    }
                }
            }
        };
    },

    methods: {
        submit() {
            let action = this.form?.id ? route('admin.users.update', { user: this.form.id }) : route('admin.users.create');
            this.form.post(action);
        },

        getDate(data) {
            return (new Date(data)).toLocaleDateString("pt-BR");
        }
    }
}

</script>