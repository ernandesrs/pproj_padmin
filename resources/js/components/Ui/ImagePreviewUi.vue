<template>
    <div class="w-100 d-flex justify-content-center">
        <div :class="[{'border': !borderless}, 'd-flex justify-content-center align-items-center mb-1 pe-none']"
            style="width: 100%; max-width: 200px; height: 100px; overflow: hidden;">
            <img class="img-fluid pe-none" v-if="previewUrl" :src="previewUrl" :alt="previewAlt">
            <span v-else class="text-muted" v-html="previewAlt"></span>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        borderless: { type: Boolean, default: false },
        previewUrl: { type: String, default: null },
        previewAlt: { type: String, default: "Preview" },
    }
};

</script>