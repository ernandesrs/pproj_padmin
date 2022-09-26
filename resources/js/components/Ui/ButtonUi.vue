<template>
    <button :type="type" :class="style" :disabled="disabled">
        <IconUi v-if="icon" :icon="icon" />
        <span :class="{'ms-2': icon && text }">
            {{text}}
        </span>
    </button>
</template>

<script>

import IconUi from './IconUi.vue';

export default {
    props: {
        text: { type: String, default: null },
        variant: { type: String, default: null },
        icon: { type: String, default: null },
        size: { type: String, default: null },
        type: { type: String, default: "button" },
        disabled: { type: Boolean, default: false },
        outlined: { type: Boolean, default: false }
    },
    computed: {
        style() {
            let bg = this.variant ? ((this.outlined ? "btn-outline-" : "btn-") + this.variant) : 'bg-transparent';
            return `btn ${this.size ? "btn-" + this.size : ""} ${bg}`;
        }
    },
    components: { IconUi }
};

</script>