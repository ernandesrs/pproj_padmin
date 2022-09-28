<template>
    <span :class="['badge bg-' + variant]">
        <IconUi v-if="icon" :icon="icon" />
        <span :class="{'ms-1': icon && text}" v-html="text"></span>
    </span>
</template>

<script>

import IconUi from './IconUi.vue';

export default {
    props: {
        text: { type: String, default: null },
        icon: { type: String, default: null },
        variant: { type: String, default: "primary" },
    },
    components: { IconUi }
};

</script>