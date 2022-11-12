<template>
    <div class="accordion-item">
        <h2 class="accordion-header" :id="['heading' + id]">
            <button :class="['accordion-button', { 'collapsed': !show }]" type="button"
                data-bs-toggle="collapse" :data-bs-target="['#collapse' + id]">
                {{ headerText }}
            </button>
        </h2>
        <div :id="['collapse' + id]"
            :class="['accordion-collapse collapse', { 'show': show }]"
            :data-bs-parent="['#' + this.$parent.$props.id]">
            <div class="accordion-body">
                <slot />
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        headerText: { type: String, default: null },
        id: { type: [String, Number], default: null },
        show: { type: Boolean, default: false },
    }
};

</script>