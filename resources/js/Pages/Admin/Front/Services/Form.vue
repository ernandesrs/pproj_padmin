<template>

    <ModalIcons :show="showIconsModal" @modalClose="showIconsModal = false"
        @iconHasChoosed="iconHasChoosed" />

    <ModalIconHelp :show="showModalIconsHelp" @modalClose="showModalIconsHelp = false" />

    <form @submit.prevent="submit">
        <div class="card card-body border-0">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-5 mb-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <InputForm label="Nome do serviço:" name="title"
                                    v-model="form.title"
                                    :error-message="form.errors.title" />
                            </div>

                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-12">
                                        <IconSetter @iconHasSet="iconHasSet"
                                            @requestingIconsModal="showIconsModal = true"
                                            @requestingModalIconsHelp="showModalIconsHelp = true"
                                            :icon-data="form.icon" :errors="form.errors"
                                            hide-position-field />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-4">
                                <TextAreaForm label="Descrição:" name="description"
                                    v-model="form.description"
                                    :error-message="form.errors.description" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <ButtonUi type="submit" variant="primary"
                        :text="`${service.id ? 'Atualizar serviço' : 'Adicionar serviço'}`"
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
import AccordionGroup from '../../../../Components/Ui/Accordion/AccordionGroup.vue';
import AccordionItem from '../../../../Components/Ui/Accordion/AccordionItem.vue';
import ModalUi from '../../../../Components/Ui/ModalUi.vue';
import ImagePreviewUi from '../../../../Components/Ui/ImagePreviewUi.vue';
import ModalImagesList from '../../Medias/Images/ModalImagesList.vue';
import TextAreaForm from '../../../../Components/Form/TextAreaForm.vue';
import LabelForm from '../../../../Components/Form/LabelForm.vue';
import IconSetter from '../../../../Components/IconSetter/IconSetter.vue';
import ModalIcons from '../../../../Components/IconSetter/ModalIcons.vue';
import ModalIconHelp from '../../../../Components/IconSetter/ModalIconHelp.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,

    components: { InputForm, ButtonUi, ButtonConfirmationUi, SelectForm, AccordionGroup, AccordionItem, ModalUi, ImagePreviewUi, ModalImagesList, TextAreaForm, IconSetter, LabelForm, IconSetter, ModalIcons, ModalIconHelp },

    props: {
        service: { type: Object, default: {} }
    },

    data() {
        return {
            form: useForm({
                id: this.service.id ?? null,
                title: this.service.title ?? null,
                description: this.service.description ?? null,
                icon: this.service.icon ?? {
                    source: 'local',
                    name: null,
                    class: null,
                    position: 'start',
                }
            }),

            showModalIconsHelp: false,
            showIconsModal: false,
        };
    },

    methods: {
        submit() {
            let action = route("admin.services.store");
            console.log(this.form.icon);
            if (this.form?.id) {
                action = route('admin.services.update', { service: this.service.id });
                this.form.put(action);
            } else {
                this.form.post(action);
            }
        },

        iconHasChoosed(icon) {
            this.showIconsModal = false;
            this.form.icon.class = icon.class;
            this.form.icon.name = icon.name;
        },

        iconHasSet(icon) {
            this.form.icon = icon;
        }
    }
}

</script>