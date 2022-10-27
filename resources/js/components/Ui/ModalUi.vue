<template>

    <Transition name="transition-fade" @after-enter="afterEnter"
        @before-leave="beforeLeave">
        <div v-if="visible" :class="['bkdrop', { 'light': light }]">
            <div @click="backdropClick"
                :class="['p-1 p-md-2 p-lg-3 p-xl-4 modal-ui', { 'top': top }]">
                <div
                    :class="['p-3 modal-ui-inner', { 'modal-ui-inner-full': size == 'full', 'modal-ui-inner-md': size == 'md', 'modal-ui-inner-lg': size == 'lg', 'h-100': fullHeight }]">
                    <CardUi noShadow>
                        <template v-slot:content>
                            <slot />
                        </template>
                    </CardUi>
                </div>
            </div>
        </div>
    </Transition>

</template>

<script>

import CardUi from './CardUi.vue';

export default {
    components: { CardUi },

    props: {
        show: { type: Boolean, default: false },
        light: { type: Boolean, default: false },
        top: { type: Boolean, default: false },
        fullHeight: { type: Boolean, default: false },
        disableBackdropClick: { type: Boolean, default: false },
        size: { type: String, default: null },
    },

    data() {
        return {
            visible: false,
            showed: false
        };
    },

    watch: {
        show: {
            immediate: true,
            handler(nv) {
                if (nv) this.showModal();
                else this.closeModal();
            }
        }
    },

    methods: {
        showModal() {
            this.visible = true;
            this.$emit("modalShow");
        },

        closeModal() {
            this.visible = false;
            this.$emit("modalClose");
        },

        backdropClick(e) {
            if (this.disableBackdropClick || !e.target.classList.contains("modal-ui")) return;
            this.closeModal();
        },

        afterEnter() {
            this.showed = true;
        },

        beforeLeave() {
            this.showed = false;
        }
    },
};

</script>
