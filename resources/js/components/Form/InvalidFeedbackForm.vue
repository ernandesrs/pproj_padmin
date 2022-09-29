<template>
    <small class="invalid-feedback">
        {{ errorMessage }}
    </small>
</template>

<script>

export default {
    props: {
        errorMessage: { type: String, default: null }
    }
};

</script>