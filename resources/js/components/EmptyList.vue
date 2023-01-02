<template>
    <div v-if="show"
        class="px-5 py-3 mt-2 mb-4 fs-5 fw-semibold text-center border text-muted">
        <span v-if="isFilter">Sem resultados para sua filtragem!</span>
        <span v-else>Sem nada para listagem!</span>
    </div>
</template>

<script>

export default {
    props: {
        show: { type: Boolean, default: false },
        isFilter: { type: Boolean, default: false },
    }
};

</script>