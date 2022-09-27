<template>
    <div class="wrapp">

        <BackdropUi @click="sidebarToggle" v-if="inMobile" v-show="sidebar.visible"
            fixed />

        <aside v-if="sidebar.visible" class="container-fluid sidebar">
            <div class="sidebar-inner">
                <header class="header">
                    <div class="container-fluid py-3">
                        <a :href="$route('admin.index')" title="Dashboard">
                            <h1 class="logo-text text-center">
                                ADMIN PANEL
                            </h1>
                        </a>
                    </div>
                </header>
                <div class="sidebar-elements">
                </div>
            </div>
        </aside>

        <div class="main" :class="{'main-full': !inMobile && !sidebar.visible}">
            <div class="container-fluid topbar">
                <div class="d-flex me-auto w-100">

                    <span class="ms-auto"></span>
                    <DropdownUi icon="userCircle" text="User Name">
                        <template v-slot:dropdownMenu>
                            <div
                                class="d-flex flex-column justify-content-center align-items-center">
                                <img class="img-fluid img-thumbnail rounded-circle"
                                    src="https://via.placeholder.com/175x175?name=photo"
                                    alt="" style="width:60px;height:60px;">
                                <h6 class="fw-semibold pt-2 text-muted text-center">
                                    User Name
                                </h6>
                            </div>
                            <DropdownDivider />
                            <DropdownHeader text="Menu" />
                            <DropdownItem text="Perfil" icon="userCircle" to="#" />
                            <DropdownItem text="Logout" icon="logout"
                                :to="$route('auth.login')" />
                        </template>
                    </DropdownUi>

                </div>

                <ButtonUi @click="sidebarToggle" :icon="sidebar.togglerIcon"
                    class="sidebar-toggler order-md-first" />
            </div>

            <main class="container-fluid content">
                <slot />
            </main>
        </div>

    </div>
</template>
  
<script>

const WIDTH_MOBILE = 768;

import ButtonUi from '../components/Ui/ButtonUi.vue';
import BackdropUi from '../components/Ui/BackdropUi.vue';
import DropdownUi from '../components/Ui/Dropdown/DropdownUi.vue';
import DropdownItem from '../components/Ui/Dropdown/DropdownItem.vue';
import DropdownDivider from '../components/Ui/Dropdown/DropdownDivider.vue';
import DropdownHeader from '../components/Ui/Dropdown/DropdownHeader.vue';

export default {
    components: { ButtonUi, BackdropUi, DropdownUi, DropdownItem, DropdownDivider, DropdownHeader },

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
                        url: this.$route("admin.index"),
                        activeIn: ['admin.index']
                    },
                ],
            },
        };
    },

    mounted() {
        this.windowResizeMonitor();
    },

    updated() {
        // this.showFlashMessage();
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

    computed: {
    },

    methods: {
        showFlashMessage() {
            let flash = this.$page.props.flash;

            if (flash) {
                this.$refs.alert.add(flash.message, flash.variant);
            } else {
                this.$refs.alert.clear();
            }
        },

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
        }
    }
}

</script>