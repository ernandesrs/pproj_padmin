<template>

    <div class="row justify-content-center">
        <div v-if="form?.id" class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="d-flex flex-column align-items-center">
                <div
                    class="profile-photo text-center img-thumbnail shadow-sm mb-2 position-relative">
                    <img class="img-fluid" v-if="user?.thumb_normal"
                        :src="user?.thumb_normal" :alt="user.full_name">
                    <div v-else class="fs-1 fw-semibold text-muted">
                        {{ user.full_name.substring(0, 2) }}
                    </div>

                </div>

                <div v-if="user.photo && user?.can?.delete" class="mb-3"
                    style="margin-top: -25px;">
                    <ButtonConfirmationUi @hasConfirmed="photoDelete" variant="danger"
                        icon="trash" size="sm" position="center"
                        confirm-text="Excluir foto?" />
                </div>

                <div v-if="form.id && user.can.update" class="px-lg-4 pt-3">
                    <InputForm @update:modelValue="photoUpload" label="Nova foto"
                        type="file" name="photo" :error-message="photoUploadError" />
                </div>

                <div class="d-flex pt-3">
                </div>
                <div class="py-3 text-center">
                    <p class="mb-0">
                        <strong>Registro:</strong> <span class="text-muted">{{
        getDate(user.created_at)
}}</span>
                    </p>
                    <p class="mb-0">
                        <BadgeUi
                            :text="`Função: ${(user.is_superadmin ? 'Superuser' : (user.role?.name ?? 'Não definido'))}`" />
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

                    <div v-if="roles?.length" class="col-12 mb-4">
                        <SelectForm label="Função" name="role" :options="Object.values(roles).map(role => {
    return {
        text: role.name,
        value: role.id
    };
})" v-model="form.role_id" :error-message="form.errors.role_id" />
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
import { Inertia } from '@inertiajs/inertia';
import Layout from './../../../Layouts/Panel.vue';
import InputForm from '../../../Components/Form/InputForm.vue';
import SelectForm from '../../../Components/Form/SelectForm.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../Components/Ui/ButtonConfirmationUi.vue';
import BadgeUi from '../../../Components/Ui/BadgeUi.vue';

export default {
    components: { InputForm, SelectForm, ButtonUi, ButtonConfirmationUi, BadgeUi },
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
                role_id: null,
                photo: null,
                gender: 'none',
                password: null,
                password_confirmation: null
            }
        },
        roles: { type: Object, default: {} },
        terms: { type: Object, default: {} },
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
                role_id: this.user?.role_id ?? null,
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

        photoDelete() {
            Inertia.delete(route('admin.users.deletePhoto', {
                'user': this.user.id
            }));
        },

        submit() {
            let action = route('admin.users.store');

            if (this.form.role_id == 'none')
                this.form.role_id = null;

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

<style scoped>
.profile-photo {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 125px;
    height: 125px;
    border-radius: 50%;
    overflow: hidden;
}

@media(min-width: 375px) {
    .profile-photo {
        width: 200px;
        height: 200px;
    }
}

@media(min-width: 768px) {
    .profile-photo {
        width: 250px;
        height: 250px;
    }
}
</style>