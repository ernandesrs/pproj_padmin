<template>

    <div class="row justify-content-center">
        <div v-if="form?.id" class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="d-flex flex-column align-items-center">
                <div>
                    <img class="img-fluid rounded-circle" :src="user.thumb_normal" />
                </div>

                <div v-if="form.id" class="px-lg-4 pt-3">
                    <InputForm @update:modelValue="photoUpload" label="Nova foto"
                        type="file" name="photo" :error-message="photoUploadError" />
                </div>

                <div class="d-flex pt-3">
                    <ButtonConfirmationUi v-if="user.next_level && user.can.promote"
                        text="Promover" confirm-text="Promover?" size="sm"
                        variant="success" icon="userPlus" class="m-1" position="center"
                        :data-action="$route('admin.users.promote', { user: user.id })"
                        confirm-with-request request-method="post" />
                    <ButtonConfirmationUi v-if="user.previous_level && user.can.demote"
                        text="Rebaixar" confirm-text="Rebaixar?" size="sm"
                        variant="danger" icon="userMinus" class="m-1" position="center"
                        :data-action="$route('admin.users.demote', { user: user.id })"
                        confirm-with-request request-method="post" />
                </div>
                <div class="py-3 text-center">
                    <p class="mb-0">
                        <strong>Registro:</strong> <span class="text-muted">{{
                        getDate(user.created_at)
                        }}</span>
                    </p>
                    <p class="mb-0">
                        <span class="badge bg-primary">
                            Nível: {{ terms.level['level_' + user.level] }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <form @submit.prevent="submit">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-4">
                        <InputForm label="Nome" name="first_name"
                            v-model="form.first_name"
                            :error-message="form.errors.first_name" />
                    </div>

                    <div class="col-12 col-sm-6 mb-4">
                        <InputForm label="Sobrenome" name="last_name"
                            v-model="form.last_name"
                            :error-message="form.errors.last_name" />
                    </div>

                    <div class="col-12 col-sm-7 col-md-6 mb-4">
                        <InputForm label="Usuário" name="username" v-model="form.username"
                            :error-message="form.errors.username" />
                    </div>

                    <div class="col-12 col-sm-5 col-md-6 mb-4">
                        <SelectForm label="Gênero" name="gender" :options="[
                            { text: 'Não definir', value: 0 },
                            { text: 'Masculino', value: 1 },
                            { text: 'Feminino', value: 2 },
                        ]" v-model="form.gender" :error-message="form.errors.gender" />
                    </div>

                    <div class="col-12 mb-4">
                        <InputForm label="Email" type="email" name="email"
                            v-model="form.email" :error-message="form.errors.email"
                            :disabled="form?.id ? true : false" />
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <InputForm label="Senha" type="password" name="password"
                            v-model="form.password"
                            :error-message="form.errors.password" />
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <InputForm label="Confirmar senha" type="password"
                            name="password_confirmation"
                            v-model="form.password_confirmation"
                            :error-message="form.errors.password_confirmation" />
                    </div>

                    <div v-if="user?.id && user.can.update || !user?.id"
                        class="col-12 text-center">
                        <ButtonUi :text="user?.id ? 'Atualizar' : 'Cadastrar'"
                            type="submit" variant="primary" icon="checkLg"
                            :disabled="form.processing" />
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
import ButtonConfirmationUi from '../../../Components/Ui/ButtonConfirmationUi.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: { InputForm, SelectForm, ButtonUi, ButtonConfirmationUi },
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
        },
        terms: { type: Object, default: {} }
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
            photoUploadError: null
        };
    },

    methods: {
        photoUpload(event) {
            let photo = event.target.files[0];

            this.photoUploadError = '';
            if (!photo) {
                this.photoUploadError = 'Selecione uma foto';
                return;
            }

            let types = ['image/png', 'image/jpg', 'image/jpeg'];
            if (!types.includes(photo.type)) {
                this.photoUploadError = 'Tipo de foto não aceito';
                return;
            }

            if (photo.size > 5242880) {
                this.photoUploadError = 'O tamanho da foto muito grande';
                return;
            }

            let action = route('admin.users.uploadPhoto', { user: this.user.id });

            Inertia.post(action, { photo: photo }, {
                preserveState: true,
                onError: (response) => {
                    if (response.photo) {
                        this.photoUploadError = response.photo;
                    } else {
                        this.photoUploadError = 'Houve um erro ao fazer upload.';
                    }
                },
                onSuccess: (response) => {
                    this.images = response.props.images;
                }
            });
        },

        submit() {
            let action = route('admin.users.store');
            if (this.form?.id) {
                action = route('admin.users.update', { user: this.form.id });

                this.form.put(action);
            } else {
                this.form.post(action);
            }
        },

        getDate(data) {
            return (new Date(data)).toLocaleDateString("pt-BR");
        },
    }
}

</script>