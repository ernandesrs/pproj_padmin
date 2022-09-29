<template>
    <label v-if="label" :for="name" class="mb-1">
        {{ label }}
    </label>
</template>

<script>

export default {
    props: {
        label: { type: String, default: null },
        name: { type: String, default: null },
    }
};

</script>