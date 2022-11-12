<template>
    <div class="accordion" :id="id">
        <slot />
    </div>
</template>

<script>

export default {
    props: {
        id: { type: [String, Number], default: "accordion" + (new Date()).getTime() }
    },
};

</script>