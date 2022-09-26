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
                <div class="me-auto"></div>

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

export default {
    components: { ButtonUi, BackdropUi },

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
            }
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