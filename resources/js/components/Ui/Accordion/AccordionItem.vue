<template>
    <div ref="accordionItem" class="accordion-item">
        <h2 class="accordion-header" :id="['heading' + id]">
            <button :class="['fw-semibold accordion-button', { 'collapsed': !show }]" type="button"
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
    },

    emits: {
        'showedIndexHasUpdated': null
    },

    data() {
        return {
            showedIndex: -1
        };
    },

    mounted() {
        this.updateAccordionItemShowedIndex();
    },

    methods: {
        updateAccordionItemShowedIndex() {
            let acitem = this.$refs.accordionItem;
            if (acitem) {
                let acitems = document.querySelectorAll('#' + this.$parent.id + ' .accordion-item .accordion-collapse');

                acitem.addEventListener('shown.bs.collapse', () => {
                    let index = -1;
                    acitems.forEach((item, key) => {
                        if (index !== -1) return;

                        if (item.classList.contains('show')) {
                            index = key;
                        }
                    });

                    this.showedIndex = index;

                    this.emitUpdatedIndexEvent();
                });
            }
        },

        emitUpdatedIndexEvent() {
            this.$emit('showedIndexHasUpdated', this.showedIndex);
        }
    }
};

</script>