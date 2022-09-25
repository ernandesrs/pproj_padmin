<template>

    <div :class="inputContainerStyle">
        <slot />
    </div>

</template>

<script>
export default {
    props: {
        isCheck: { type: Boolean, default: false },
        isRadio: { type: Boolean, default: false },
        inline: { type: Boolean, default: false },
    },

    computed: {
        inputContainerStyle() {
            return `${this.isCheck || this.isRadio ? 'form-check' + (this.inline ? ' form-check-inline' : '') : 'input-group'} has-validation mb-3`;
        },
    }
};
</script>