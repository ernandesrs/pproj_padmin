<template>
    <div :class="['tab-pane fade show', { 'active': show }]" :id="`${name}TabPane`"
        role="tabpanel" :aria-labelledby="`${navName}`" tabindex="0">
        <div class="py-3 px-3">
            <slot />
        </div>
    </div>
</template>

<script>

export default {
    props: {
        name: { type: String, default: null },
        navName: { type: String, default: null },
        show: { type: Boolean, default: false },
    },
};

</script>