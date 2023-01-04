<template>

    <div class="row justify-content-center py-3">
        <div
            class="col-12 mb-4 d-flex flex-column justify-content-center align-items-center">
            <div class="profile-photo text-center img-thumbnail shadow-sm">
                <img class="img-fluid" v-if="me?.thumb_normal" :src="me?.thumb_normal"
                    :alt="me.full_name">
                <div v-else class="fs-1 fw-semibold text-muted">
                    {{ me.full_name.substring(0, 2) }}
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-10 col-lg-8 col-xl-6">
            <form @submit.prevent="submit">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <InputForm label="Nome:" v-model="form.first_name"
                            :error-message="form.errors.first_name" />
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <InputForm label="Sobrenome:" v-model="form.last_name"
                            :error-message="form.errors.last_name" />
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <InputForm label="Usuário:" v-model="form.username"
                            :error-message="form.errors.username" />
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <SelectForm label="Gênero:" :options="[
    {
        text: 'Não definido',
        value: 0
    },
    {
        text: 'Masculino',
        value: 1
    },
    {
        text: 'Feminino',
        value: 2
    }
]" v-model="form.gender" :error-message="form.errors.gender" />
                    </div>

                    <div class="col-12 mb-3">
                        <InputForm label="Email:" v-model="form.email"
                            :error-message="form.errors.email" disabled />
                    </div>

                    <div class="col-12 mb-3">
                        <InputForm @update:modelValue="form.photo = $event.target.files[0]"
                            type="file" label="Nova foto:"
                            :error-message="form.errors.photo" />
                        <progress v-if="form.progress" :value="form.progress.percentage"
                            max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <InputForm type="password" label="Senha:" v-model="form.password"
                            :error-message="form.errors.password" />
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <InputForm type="password" label="Confirmar senha:"
                            v-model="form.password_confirmation"
                            :error-message="form.errors.password_confirmation" />
                    </div>

                    <div class="col-12 text-center">
                        <ButtonUi type="submit" variant="primary" text="Atualizar perfil"
                            icon="checkLg" :disabled="form.processing" />
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<script>

import { useForm } from '@inertiajs/inertia-vue3';
import Layout from './../../Layouts/Panel.vue';
import InputForm from '../../Components/Form/InputForm.vue';
import SelectForm from '../../Components/Form/SelectForm.vue';
import ButtonUi from '../../Components/Ui/ButtonUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, SelectForm, ButtonUi },
    props: {
        me: { type: Object, default: {} }
    },
    data() {
        return {
            form: useForm({
                id: this.me.id,
                first_name: this.me.first_name,
                last_name: this.me.last_name,
                username: this.me.username,
                gender: this.me.gender,
                email: this.me.email,
                photo: null,
                password: null,
                password_confirmation: null,
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(route('admin.profile.update'));
        }
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