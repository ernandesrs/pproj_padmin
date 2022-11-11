<template>

    <form @submit.prevent="submit">
        <div class="card card-body border-0">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-6 mb-4">
                    <InputForm type="text" name="name" v-model="form.name"
                        label="Nome do menu:" :error-message="form.errors.name" />
                </div>

                <div class="col-12 col-md-10 col-lg-6 mb-4">
                    <div class="row">
                        <div class="col-12 mb-4 text-center">
                            <ButtonUi @click="addMenuItem" type="button" variant="info"
                                text="Novo item de menu" icon="plusLg" size="sm" />
                        </div>

                        <div v-for="item, key in items" :key="key" class="col-12 mb-2">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <InputForm label="Texto:" v-model="item.text" />
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <InputForm label="Título:" v-model="item.title" />
                                    </div>
                                    <div class="col-12 col-md-5 mb-3">
                                        <InputForm label="URL:" v-model="item.url" />
                                    </div>
                                    <div class="col-12 col-md-4 mb-3">
                                        <SelectForm label="Abrir na:" :options="[
                                            {
                                                value: '_self',
                                                text: 'Aba atual'
                                            },
                                            {
                                                value: '_blank',
                                                text: 'Outra aba'
                                            }
                                        ]" v-model="item.target" />
                                    </div>
                                    <div class="col-12 text-center">
                                        <ButtonConfirmationUi @hasConfirmed="removeItem"
                                            @hasCanceled="" icon="trash" variant="danger"
                                            size="sm" position="center"
                                            :data-item="key" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <ButtonUi type="submit" variant="primary" text="Salvar menu"
                        icon="checkLg" :disabled="form.processing" />
                </div>
            </div>
        </div>
    </form>

</template>

<script>

import Layout from './../../../../Layouts/Panel.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import InputForm from '../../../../Components/Form/InputForm.vue';
import ButtonUi from '../../../../Components/Ui/ButtonUi.vue';
import ButtonConfirmationUi from '../../../../Components/Ui/ButtonConfirmationUi.vue';
import SelectForm from '../../../../Components/Form/SelectForm.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ButtonConfirmationUi, SelectForm },
    props: {
    },

    data() {
        return {
            form: useForm({
                name: null,
                items: null,
            }),
            items: []
        };
    },

    methods: {
        submit() {
            let action = route("admin.menus.store");

            this.form.items = this.items;

            this.form.post(action);
        },

        addMenuItem() {
            this.items.unshift({
                text: "Menu item text",
                url: "https://example.com",
                target: "_self",
                title: "Menu item title"
            });
        },

        removeItem(event) {
            let item = event.path[2].getAttribute("data-item");
            if (!item) return;

            this.items.splice(item, 1);

            console.log(this.items);
        }
    }
}

</script>