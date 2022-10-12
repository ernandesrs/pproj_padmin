<template>
    <span :class="theIcon"></span>
</template>

<script>

export default {
    props: {
        icon: { type: String, default: 'app' },
    },

    computed: {
        theIcon() {
            return `icon ${this.getIcon(this.icon)}`;
        }
    },

    methods: {
        getIcon(iconName) {
            return this.$icons[iconName];
        }
    },
};

</script>