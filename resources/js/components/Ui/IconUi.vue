<template>
    <span :class="theIcon"></span>
</template>

<script>

import icons from './../../utils/icons';

export default {
    props: {
        icon: { type: String, default: 'app' }
    },

    computed: {
        theIcon() {
            return `icon ${icons.get(this.icon)}`;
        }
    },
};

</script>