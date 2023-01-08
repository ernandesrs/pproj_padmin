<template>

    <ModalImagesList :show="showImagesModalList" @modalClose="modalImagesListClose"
        @imageInsert="insertImage" />

    <form @submit.prevent="submit">
        <TabpanelUi horizontal pills>
            <template v-slot:tabNavs>
                <TabNavItem text="Geral" name="generalNav" contentName="generalContent"
                    show />
                <TabNavItem text="Conteúdo" name="contentNav"
                    contentName="contentContent" />
                <TabNavItem text="Outros" name="othersNav" contentName="othersContent" />
            </template>

            <template v-slot:tabContents>
                <TabContent name="generalContent" navName="generalNav" show>
                    <div class="card card-body mb-4 h-100">
                        <h2 class="fs-5 fw-semibold">Redes sociais</h2>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6 mb-3">
                                <InputForm label="Facebook:" name="facebook"
                                    v-model="form.socials.facebook" />
                                <small>facebook.com/{{ form.socials.facebook }}</small>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <InputForm label="Instagram:" name="instagram"
                                    v-model="form.socials.instagram" />
                                <small>instagram.com/{{ form.socials.instagram }}</small>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <InputForm label="Twitter:" name="twitter"
                                    v-model="form.socials.twitter" />
                                <small>twitter.com/{{ form.socials.twitter }}</small>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <InputForm label="Linkedin:" name="linkedin"
                                    v-model="form.socials.linkedin" />
                                <small>linkedin.com/in/{{ form.socials.linkedin }}</small>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <InputForm label="Github:" name="github"
                                    v-model="form.socials.github" />
                                <small>github.com/{{ form.socials.github }}</small>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <InputForm label="Youtube:" name="youtube"
                                    v-model="form.socials.youtube" />
                                <small>youtube.com/@{{ form.socials.youtube }}</small>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <InputForm label="Tiktok:" name="tiktok"
                                    v-model="form.socials.tiktok" />
                                <small>tiktok.com/@{{ form.socials.tiktok }}</small>
                            </div>
                        </div>
                    </div>
                </TabContent>
                <TabContent name="contentContent" navName="contentNav">
                    <div class="row">
                        <div class="col-12 col-xl-6 mb-4">
                            <div class="card card-body mb-4 h-100">
                                <h2 class="fs-5 fw-semibold">Cabeçalho</h2>
                                <div class="row mb-4">
                                    <div class="col-6 mb-4 text-center">
                                        <ImagePreviewUi :preview-url="faviconPreview"
                                            preview-alt="Favicon preview"
                                            :borderless="faviconPreview ? true : false"
                                            class="mb-2" />

                                        <ButtonUi @click="modalImagesListShow"
                                            text="Novo favicon" icon="image"
                                            variant="success" size="sm"
                                            data-to="favicon" />
                                    </div>

                                    <div class="col-6 mb-4 text-center">
                                        <ImagePreviewUi :preview-url="logoPreview"
                                            preview-alt="Logo preview"
                                            :borderless="logoPreview ? true : false"
                                            class="mb-2" />

                                        <ButtonUi @click="modalImagesListShow"
                                            text="Novo logo" icon="image"
                                            variant="success" size="sm" data-to="logo" />
                                    </div>

                                    <div class="col-12">
                                        <SelectForm label="Menu principal:"
                                            name="menu_main"
                                            v-model="form.header.menu_main.id" :options="menus.map((menu) => {
                                                return {
                                                    text: menu.name,
                                                    value: menu.id
                                                };
                                            })"
                                            :error-message="form.errors['header.menu_main']" />
                                    </div>
                                </div>

                                <h2 class="fs-5 fw-semibold">Rodapé</h2>
                                <div class="row">
                                    <div class="col-12">
                                        <SelectForm label="Menu rodapé:"
                                            name="menu_footer"
                                            v-model="form.footer.menu_footer.id" :options="menus.map((menu) => {
                                                return {
                                                    text: menu.name,
                                                    value: menu.id
                                                };
                                            })"
                                            :error-message="form.errors['footer.menu_footer']" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-6 mb-4">
                            <div class="card card-body mb- h-100">
                                <h2 class="fs-5 fw-semibold">Corpo</h2>
                                <p class="text-muted">
                                    Crie seções em <strong>Seções</strong> >
                                    <Link :href="$route('admin.sections.create')">
                                    <strong>Nova seção</strong>
                                    </Link> e defina abaixo quais delas serão exibidas.
                                </p>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <SelectForm label="Seção 1:" name="section_1"
                                            v-model="form.pages.home.section_1"
                                            :options="sectionsOptions(['banner'])"
                                            :error-message="form.errors['sections.section_1']" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <SelectForm label="Seção 2:" name="section-2"
                                            v-model="form.pages.home.section_2"
                                            :options="sectionsOptions(['default'])"
                                            :error-message="form.errors['sections.section_2']" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <SelectForm label="Seção 3:" name="section_3"
                                            v-model="form.pages.home.section_3"
                                            :options="sectionsOptions(['bindable'])"
                                            :error-message="form.errors['sections.section_3']" />
                                    </div>
                                    <div class="col-12 mb-4">
                                        <SelectForm label="Seção 4:" name="section_4"
                                            v-model="form.pages.home.section_4"
                                            :options="sectionsOptions(['default'])"
                                            :error-message="form.errors['sections.section_4']" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </TabContent>
                <TabContent name="othersContent" navName="othersNav">
                    Outros
                </TabContent>
            </template>
        </TabpanelUi>

        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <ButtonUi text="Atualizar" icon="checkLg" type="submit"
                    variant="primary" />
            </div>
        </div>
    </form>

</template>

<script>

import { Link, useForm } from '@inertiajs/inertia-vue3';
import Layout from './../../../Layouts/Panel.vue';
import InputForm from '../../../Components/Form/InputForm.vue';
import ButtonUi from '../../../Components/Ui/ButtonUi.vue';
import ImagePreviewUi from '../../../Components/Ui/ImagePreviewUi.vue';
import ModalImagesList from '../Medias/Images/ModalImagesList.vue';
import TextAreaForm from '../../../Components/Form/TextAreaForm.vue';
import SelectForm from '../../../Components/Form/SelectForm.vue';
import TabpanelUi from '../../../Components/Ui/Tabpanel/TabpanelUi.vue';
import TabNavItem from '../../../Components/Ui/Tabpanel/TabNavItem.vue';
import TabContent from '../../../Components/Ui/Tabpanel/TabContent.vue';

export default {
    layout: (h, page) => h(Layout, () => child),
    layout: Layout,
    components: { InputForm, ButtonUi, ImagePreviewUi, ModalImagesList, TextAreaForm, SelectForm, Link, TabpanelUi, TabNavItem, TabContent },
    props: {
        settings: { type: Object, default: {} },
        menus: { type: Object, default: {} },
        terms: { type: Object, default: {} },
        sections: { type: Object, default: {} },
    },

    data() {
        return {
            faviconPreview: this.settings?.content?.header?.favicon?.path_url ?? null,
            logoPreview: this.settings?.content?.header?.logo?.path_url ?? null,
            form: useForm({
                socials: {
                    facebook: this.settings?.content?.socials?.facebook ?? null,
                    instagram: this.settings?.content?.socials?.instagram ?? null,
                    youtube: this.settings?.content?.socials?.youtube ?? null,
                    twitter: this.settings?.content?.socials?.twitter ?? null,
                    tiktok: this.settings?.content?.socials?.tiktok ?? null,
                    github: this.settings?.content?.socials?.github ?? null,
                    linkedin: this.settings?.content?.socials?.linkedin ?? null,
                },
                header: {
                    favicon: null,
                    logo: null,
                    menu_main: this.settings?.content?.header?.menu_main ?? {
                        id: null
                    },
                },
                pages: {
                    home: {
                        section_1: this.settings?.content?.pages?.home?.section_1?.id ?? null,
                        section_2: this.settings?.content?.pages?.home?.section_2?.id ?? null,
                        section_3: this.settings?.content?.pages?.home?.section_3?.id ?? null,
                        section_4: this.settings?.content?.pages?.home?.section_4?.id ?? null,
                    }
                },
                footer: {
                    menu_footer: this.settings?.content?.footer?.menu_footer ?? {
                        id: null
                    },
                }

            }),
            showImagesModalList: false,
            showImagesModalListTo: null
        };
    },

    methods: {
        submit() {
            if (this.form.header.menu_main.id == "none")
                this.form.header.menu_main.id = null;

            if (this.form.footer.menu_footer.id == "none")
                this.form.footer.menu_footer.id = null;

            this.form.post(route("admin.settings.update"));
        },

        modalImagesListShow(event) {
            this.showImagesModalListTo = event.target.getAttribute("data-to");
            this.showImagesModalList = true;
        },

        modalImagesListClose() {
            this.showImagesModalList = false;
        },

        insertImage(data) {
            if (this.showImagesModalListTo == 'favicon') {
                this.faviconPreview = data.url;
                this.form.header.favicon = data.id;
            } else {
                this.logoPreview = data.url;
                this.form.header.logo = data.id;
            }
        },

        sectionsOptions(allowedSectionTypes = []) {
            return this.sections.filter((section) => {
                return allowedSectionTypes.includes(section.type);
            }).map((section) => {
                return {
                    text: `${section.name}`,
                    value: section.id
                };
            });
        }
    }
}
</script>