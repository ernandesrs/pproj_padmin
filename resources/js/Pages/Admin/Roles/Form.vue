<template>

    <form @submit.prevent="submit">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 col-xl-6 mb-4">
                <div class="row">
                    <div class="col-12 mb-4">
                        <InputForm type="text" label="Nome da função:" name="name"
                            v-model="form.name" :error-message="form.errors.name" />
                    </div>

                    <div class="col-12 mb-4">
                        <InputForm type="checkbox"
                            label="Acesso ao administrativo" name="admin_panel_access" v-model="form.admin_access" />
                    </div>

                    <div v-for="rulable in rulables" class="col-12 mb-4">
                        <div class="d-flex flex-wrap align-items-start">
                            <span class="inline-block me-2 fs-6 fw-semibold">
                                {{ rulablesText[rulable] }}
                            </span>
                            <InputForm @hasChange="checkAll" type="checkbox"
                                label="Marcar todos" :name="`${rulable}`" />
                        </div>
                        <hr>
                        <div class="d-flex flex-wrap">
                            <div class="p-1" v-for="rule in rules">
                                <InputForm type="checkbox" :label="rulesText[rule]"
                                    :name="`${rulable}_${rule}`"
                                    v-model="form.rulables[rulable][rule]" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <ButtonUi type="submit"
                            :text="role.id ? 'Atualizar' : 'Cadastrar'" variant="primary"
                            icon="checkLg" :disabled="form.processing" />
                    </div>
                </div>
            </div>
        </div>
    </form>

</template>

<script>

import Layout from './../../../Layouts/Panel.vue';
import InputForm from '../../../Components/Form/InputForm.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi },
    props: {
        role: { type: Object, default: {} },
        rulables: { type: Object, default: {} },
        rules: { type: Object, default: {} },
    },

    data() {
        return {
            form: useForm({
                id: null,
                name: null,
                admin_access: null,
                rulables: {}
            }),

            rulablesText: {
                role: "Função",
                service: "Serviço",
                image: "Imagem",
                video: "Vídeo",
                section: "Seção",
                content: "Conteúdo",
                menu: "Menu",
                page: "Página",
                user: "Usuário",
            },

            rulesText: {
                view: "Ver",
                viewAny: "Ver todos",
                create: "Criar",
                update: "Atualizar",
                delete: "Excluir",
                forceDelete: "Excluir(forçado)",
                restore: "Restaurar",
            },
        };
    },
    created() {
        this.setRoleContentOnForm();
    },
    methods: {
        checkAll(event) {
            let checkAllRulable = event.target.getAttribute("name");

            if (event.target.checked) {
                Object.keys(this.form.rulables[checkAllRulable]).map(rulable => {
                    this.form.rulables[checkAllRulable][rulable] = true;
                });
            } else {
                Object.keys(this.form.rulables[checkAllRulable]).map(rulable => {
                    this.form.rulables[checkAllRulable][rulable] = false;
                });
            }
        },

        submit() {
            let action = route("admin.roles.store");

            if (this.role?.id) {
                action = route("admin.roles.update", { role: this.role.id });
                this.form.put(action);
            } else {
                this.form.post(action);
            }
        },

        setRoleContentOnForm() {
            if (!this.role?.id) {
                Object.values(this.rulables).map(rulable => {
                    this.form.rulables[rulable] = {};

                    Object.values(this.rules).map(rule => {
                        this.form.rulables[rulable][rule] = false;
                    });
                });

                return;
            }

            this.form.name = this.role.name;
            this.form.admin_access = this.role.admin_access;
            this.form.rulables = this.role.rulables;
        },
    }
};

</script>