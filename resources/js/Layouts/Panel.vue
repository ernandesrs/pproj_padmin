<template>

    <Head :title="`[${appName} Admin] &raquo; ${pageTitle}`" />

    <div class="wrapp">

        <BackdropUi @click="sidebarToggle" v-if="inMobile" v-show="sidebar.visible"
            fixed />

        <aside v-if="sidebar.visible" class="container-fluid sidebar alt-sidebar">
            <div class="sidebar-inner">
                <header class="header">
                    <div class="container-fluid py-3">
                        <a :href="$route('admin.index')" title="Dashboard">
                            <h1 class="logo-text text-center">
                                <p class="fs-4 fw-semibold text-white mb-0">{{
                                        appName.toUpperCase()
                                }}</p>
                                <p class="fs-6 fw-semibold text-light-dark mb-0">ADMIN</p>
                            </h1>
                        </a>
                    </div>
                </header>

                <div class="sidebar-elements">
                    <div class="sidebar-element">
                        <NavUi>
                            <template v-for="(nav, key) in sidebar.navs" :key="nav.text">
                                <NavItemUi v-if="!nav.items" :item="nav" />

                                <template v-else>
                                    <NavItemUi :item="nav" subnav
                                        data-bs-toggle="collapse"
                                        :href="('#subnav' + key)" />

                                    <div :class="['collapse', { 'show': nav.activeIn.includes($page.component) }]"
                                        :id="('subnav' + key)">
                                        <NavUi subnav>
                                            <template v-for="subnav in nav.items"
                                                :key="subnav.text">
                                                <NavItemUi :item="subnav" />
                                            </template>
                                        </NavUi>
                                    </div>
                                </template>
                            </template>
                        </NavUi>
                    </div>
                </div>
            </div>
        </aside>

        <div class="main" :class="{ 'main-full': !inMobile && !sidebar.visible }">
            <div class="container-fluid topbar">
                <div class="d-flex me-auto w-100">

                    <span class="ms-auto"></span>
                    <DropdownUi icon="userCircle"
                        :text="`${$helpers.string.substr(auth.full_name, 8)}`">
                        <template v-slot:dropdownMenu>
                            <div
                                class="d-flex flex-column justify-content-center align-items-center">
                                <img class="img-fluid img-thumbnail rounded-circle"
                                    :src="(auth.thumb_small ?? auth.thumb_normal)" :alt="auth.full_name"
                                    style="width:60px;height:60px;">
                                <h6 class="fw-semibold pt-2 text-muted text-center">
                                    {{ auth.full_name }}
                                </h6>
                            </div>
                            <DropdownDivider />
                            <DropdownHeader text="Menu" />
                            <DropdownItem text="Perfil" icon="userCircle" :to="$route('admin.users.edit', {user: auth.id})" />
                            <DropdownItem text="Logout" icon="logout"
                                :to="$route('auth.logout')" />
                        </template>
                    </DropdownUi>

                </div>

                <ButtonUi @click="sidebarToggle" :icon="sidebar.togglerIcon"
                    :class="['sidebar-toggler order-md-first', { 'close-mode': sidebar.visible && inMobile }]" />
            </div>

            <main class="container-fluid content">
                <div v-if="$page.component != 'Admin/Index'"
                    class="mt-4 d-flex align-items-center">

                    <h1 class="fs-5 fw-semibold mb-0">{{ $page.props.pageTitle }}</h1>

                    <div v-if="buttons" class="ms-2">
                        <ButtonUi v-if="buttons?.back"
                            :text="`${buttons.back.text ?? 'Voltar'}`"
                            :icon="`${buttons.back.icon ?? 'arrowLeft'}`"
                            variant="primary" :to="buttons.back?.url" />
                        <span class="mx-1"></span>
                        <ButtonUi v-if="buttons.new"
                            :text="`${buttons.new.text ?? 'Criar novo'}`"
                            :icon="`${buttons.new.icon ?? 'plusLg'}`" variant="success"
                            :to="buttons.new.url" />
                    </div>

                    <div class="ms-auto">
                        <Filter v-if="$page.props?.filterAction" />
                    </div>
                </div>

                <AlertUi :variant="flash?.variant" :message="flash?.message" />

                <div class="mt-4 py-4 px-4 content-inner">
                    <slot />
                </div>

                <footer class="py-2 footer">
                    <small class="text-center">
                        <p class="mb-0">
                            Criado por <a href="https://www.github.com/ernandesrs"
                                target="_blank" title="Github">Ernandes</a>
                        </p>
                    </small>
                </footer>
            </main>
        </div>

    </div>
</template>
  
<script>

const WIDTH_MOBILE = 768;

import { Head } from '@inertiajs/inertia-vue3';
import ButtonUi from '../Components/Ui/ButtonUi.vue';
import BackdropUi from '../Components/Ui/BackdropUi.vue';
import DropdownUi from '../Components/Ui/Dropdown/DropdownUi.vue';
import DropdownItem from '../Components/Ui/Dropdown/DropdownItem.vue';
import DropdownDivider from '../Components/Ui/Dropdown/DropdownDivider.vue';
import DropdownHeader from '../Components/Ui/Dropdown/DropdownHeader.vue';
import NavItemUi from '../Components/Nav/NavItemUi.vue';
import NavUi from '../Components/Nav/NavUi.vue';
import AlertUi from '../Components/Ui/AlertUi.vue';
import Filter from '../Components/Filter.vue';

export default {
    components: { Head, ButtonUi, BackdropUi, DropdownUi, DropdownItem, DropdownDivider, DropdownHeader, NavItemUi, NavUi, AlertUi, Filter },

    props: {
        auth: { type: Object, default: {} },
        buttons: { type: Object, default: {} },
        appName: { type: String, default: null },
        pageTitle: { type: String, default: null },
        flash: { type: Object, default: null }
    },

    data() {
        return {
            windowWidth: null,
            inMobile: false,
            sidebar: {
                visible: true,
                togglerIcon: null,
                navs: [
                    {
                        text: 'Dashboard',
                        to: this.$route("admin.index"),
                        icon: 'pieChart',
                        activeIn: ['Admin/Index']
                    },
                    {
                        text: 'Usuarios',
                        to: this.$route("admin.users.index"),
                        icon: 'users',
                        activeIn: ['Admin/Users/List', 'Admin/Users/Form']
                    },
                    {
                        text: 'Mídias',
                        href: '#',
                        icon: 'collection',
                        activeIn: ['Admin/Medias/Images/List', 'Admin/Medias/Images/Form'],
                        items: [
                            {
                                text: 'Imagens',
                                to: this.$route('admin.medias.images.index'),
                                icon: 'images',
                                activeIn: ['Admin/Medias/Images/List', 'Admin/Medias/Images/Form']
                            }
                        ]
                    },
                    {
                        text: 'Gerenciar site',
                        to: '#',
                        icon: 'layoutWtf',
                        activeIn: ['Admin/Pages/List', 'Admin/Pages/Form', 'Admin/Front/Settings'],
                        items: [
                            {
                                text: 'Páginas',
                                to: this.$route("admin.pages.index"),
                                icon: 'fileEarmarkText',
                                activeIn: ['Admin/Pages/List', 'Admin/Pages/Form']
                            },
                            {
                                text: 'Configurações',
                                to: this.$route("admin.settings.edit"),
                                icon: 'cog',
                                activeIn: ['Admin/Front/Settings']
                            }
                        ]
                    }
                ],
            },
        };
    },

    mounted() {
        this.windowResizeMonitor();
    },

    watch: {
        windowWidth(nv) {
            if (nv < WIDTH_MOBILE) {
                this.inMobile = true;
                this.sidebar.visible = false;
            } else {
                this.inMobile = false;
                this.sidebar.visible = true;
            }
        },
        sidebar: {
            immediate: true,
            handler(nv) {
                if (nv.visible)
                    this.sidebar.togglerIcon = 'listLeft';
                else
                    this.sidebar.togglerIcon = 'listRight';
            },
            deep: true
        }
    },

    methods: {
        sidebarToggle() {
            this.sidebar.visible = !this.sidebar.visible;
        },

        windowResizeMonitor() {
            this.getWindowSize();

            window.addEventListener("resize", () => {
                this.getWindowSize();
            });
        },

        getWindowSize() {
            let currentWidth = window.innerWidth;

            if (currentWidth < WIDTH_MOBILE && (!this.windowWidth || this.windowWidth > currentWidth))
                this.windowWidth = currentWidth;
            else if (currentWidth >= WIDTH_MOBILE && (!this.windowWidth || this.windowWidth <= currentWidth))
                this.windowWidth = currentWidth;
        },
    }
}

</script>

