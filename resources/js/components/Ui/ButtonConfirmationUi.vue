<template>

    <div class="position-relative">
        <!-- the button -->
        <ButtonUi @click="click" type="button" :text="text" :icon="icon"
            :variant="variant" :size="size" :outlined="outlined" />

        <Transition :name="animationName">
            <div v-if="showConfirmButtons"
                class="d-flex align-items-center bg-light shadow py-2 px-3 buttons"
                :class="`${'position-' + position}`">
                <span :class="['fs-6 fw-normal px-2 text-' + variant]">
                    {{ confirmText }}
                </span>

                <!-- confirm button -->
                <ButtonUi @click="confirm" type="button" variant="success" :size="size"
                    class="ms-2" :data-action="dataAction" :icon="buttonConfirm.icon"
                    :disabled="buttonConfirm.disabled" />

                <!-- cancel button -->
                <ButtonUi @click="cancel" type="button" variant="danger" :size="size"
                    class="ms-2" :icon="buttonCancel.icon"
                    :disabled="buttonCancel.disabled" />
            </div>
        </Transition>
    </div>

</template>

<script>

import { Inertia } from '@inertiajs/inertia';
import ButtonUi from './ButtonUi.vue';

export default {
    components: { ButtonUi },
    props: {
        text: { type: String, default: null },
        variant: { type: String, default: null },
        icon: { type: String, default: null },
        size: { type: String, default: null },

        dataAction: { type: String, default: null },
        confirmWithRequest: { type: Boolean, default: false },
        requestMethod: { type: String, default: 'get' },

        position: { type: String, default: 'right' },

        disabled: { type: Boolean, default: false },
        outlined: { type: Boolean, default: false },

        confirmText: { type: String, default: 'Confirmar?' },
    },

    data() {
        return {
            showConfirmButtons: false,
            waitRequest: false,
            buttonConfirm: {
                icon: 'checkLg',
                disabled: false
            },
            buttonCancel: {
                icon: 'xLg',
                disabled: false
            }
        };
    },

    mounted() {
        document.addEventListener("click", this.clickOut);
    },

    methods: {
        click(e) {
            this.$emit("hasClicked", e);
            this.showConfirmButtons = true;
        },

        confirm(e) {
            if (!this.confirmWithRequest) {
                this.close();
                this.$emit("hasConfirmed", e);
                return;
            }

            this.request(e);
        },

        cancel(e) {
            this.$emit("hasCanceled", e);
            this.close();
        },

        clickOut(e) {
            if (this.waitRequest)
                return;
            if (this.$el.contains(e.target))
                return;
            this.cancel(e);
        },

        close() {
            this.showConfirmButtons = false;
        },

        request(e) {
            let action = e.target.getAttribute("data-action");

            if (!action)
                return;

            let methods = ["GET", "POST", "DELETE", "PUT", "DELETE"];
            let method = this.requestMethod.toUpperCase();

            if (!methods.includes(method))
                return;

            Inertia.visit(action, {
                method: method,
                data: null,
                onStart: visit => {
                    this.waitRequest = true;
                    this.buttonCancel.disabled = this.buttonConfirm.disabled = true;
                    this.buttonConfirm.icon = 'loading';
                },
                onFinish: visit => {
                    this.waitRequest = false;
                    this.buttonCancel.disabled = this.buttonConfirm.disabled = false;
                    this.buttonConfirm.icon = 'checkLg';
                    this.close();
                }
            });
        }
    },

    computed: {
        animationName() {
            return `slide-fade-${this.position}`;
        }
    },
};

</script>

<style>
.buttons {
    position: absolute;
    z-index: 100;
    top: 50%;
}

.position-left {
    left: 0;
    transform: translate(0%, -50%) scale(1);
}

.position-center {
    right: 50%;
    transform: translate(50%, -50%) scale(1);
}

.position-right {
    right: 0;
    transform: translate(0%, -50%) scale(1);
}

.slide-fade-left-enter-from,
.slide-fade-left-leave-to {
    transform: translate(-100%, -50%) scale(0.75);
    opacity: 0;
}

.slide-fade-center-enter-from,
.slide-fade-center-leave-to {
    transform: translate(50%, -50%) scale(0.75);
    opacity: 0;
}

.slide-fade-right-enter-from,
.slide-fade-right-leave-to {
    transform: translate(100%, -50%) scale(0.75);
    opacity: 0;
}

.slide-fade-right-enter-active,
.slide-fade-left-enter-active,
.slide-fade-center-enter-active {
    transition: all 0.25s ease-out;
}

.slide-fade-right-leave-active,
.slide-fade-left-leave-active,
.slide-fade-center-leave-active {
    transition: all 0.25s ease-in-out;
}
</style>