<template>
    <button :type="type" :class="style" :disabled="disabled">
        {{text}}
    </button>
</template>

<script>
export default {
    props: {
        text: { type: String, default: null },
        variation: { type: String, default: 'primary' },
        size: { type: String, default: null },
        type: { type: String, default: 'button' },
        disabled: { type: Boolean, default: false },
        outlined: { type: Boolean, default: false }
    },
    computed: {
        style() {
            return `btn ${this.size ? 'btn-' + this.size : null} ${(this.outlined ? "btn-outline-" : "btn-") + this.variation}`;
        }
    },
};
</script>