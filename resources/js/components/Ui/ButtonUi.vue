<template>
    <button :type="type" :class="style" :disabled="disabled">
        <IconUi v-if="icon" :icon="icon" />
        <span :class="{'ms-2': icon }">
            {{text}}
        </span>
    </button>
</template>

<script>

import IconUi from './IconUi.vue';

export default {
    props: {
        text: { type: String, default: null },
        variation: { type: String, default: "primary" },
        icon: { type: String, default: null },
        size: { type: String, default: null },
        type: { type: String, default: "button" },
        disabled: { type: Boolean, default: false },
        outlined: { type: Boolean, default: false }
    },
    computed: {
        style() {
            return `btn ${this.size ? "btn-" + this.size : null} ${(this.outlined ? "btn-outline-" : "btn-") + this.variation}`;
        }
    },
    components: { IconUi }
};

</script>