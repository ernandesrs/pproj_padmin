<template>

    <div class="position-relative bg-warning">
        <!-- the button -->
        <ButtonUi @click="click" type="button" :text="text" :icon="icon"
            :variant="variant" :size="size" :outlined="outlined" />

        <div v-if="showConfirmButtons"
            class="d-flex align-items-center bg-light shadow py-2 px-3 position-absolute top-50 end-0 translate-middle-y">
            <span :class="['fs-6 fw-normal px-2 text-' + variant]">
                {{ confirmText }}
            </span>

            <!-- confirm button -->
            <ButtonUi @click="confirm" type="button" icon="checkLg" variant="success"
                :size="size" class="ms-2" :data-action="dataAction" />

            <!-- cancel button -->
            <ButtonUi @click="cancel" type="button" icon="xLg" variant="danger"
                :size="size" class="ms-2" />
        </div>
    </div>

</template>

<script>

import ButtonUi from './ButtonUi.vue';

export default {
    components: { ButtonUi },
    props: {
        text: { type: String, default: null },
        variant: { type: String, default: null },
        icon: { type: String, default: null },
        size: { type: String, default: null },
        dataAction: { type: String, default: null },

        disabled: { type: Boolean, default: false },
        outlined: { type: Boolean, default: false },

        confirmText: { type: String, default: 'Confirmar?' },
    },

    data() {
        return {
            showConfirmButtons: false
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
            this.$emit("hasConfirmed", e);
        },

        cancel(e) {
            this.$emit("hasCanceled", e);
            this.showConfirmButtons = false;
        },

        clickOut(e) {
            if (this.$el.contains(e.target))
                return;
            this.cancel(e);
        }
    }
};

</script>