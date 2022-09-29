<template>

    <div class="position-relative">
        <!-- the button -->
        <ButtonUi @click="click" type="button" :text="text" :icon="icon"
            :variant="variant" :size="size" :outlined="outlined" />

        <div v-if="showConfirmButtons"
            class="d-flex align-items-center bg-light position-absolute top-0 end-0">
            <span :class="['fs-6 fw-normal me-2 text-' + variant]">
                {{ confirmText }}
            </span>

            <!-- confirm button -->
            <ButtonUi @click="confirm" type="button" :text="text" icon="checkLg"
                variant="success" :size="size" class="ms-1 me-1"
                :data-action="dataAction" />

            <!-- cancel button -->
            <ButtonUi @click="cancel" type="button" :text="text" icon="xLg"
                variant="danger" :size="size" class="ms-1 me-1" />
        </div>
    </div>

</template>

<script>

import ButtonUi from './ButtonUi.vue';

export default {
    data() {
        return {
            showConfirmButtons: false
        };
    },
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
        }
    }
};

</script>