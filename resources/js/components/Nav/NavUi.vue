<template>

    <nav :class="['nav flex-column', {'subnav ps-3': subnav}]">
        <slot />
    </nav>

</template>

<script>

export default {
    props: {
        subnav: { type: Boolean, default: false },
    }
};

</script>
