<template>
    <div class="pb-3 mt-3 mb-4 shadow-sm">
        <div class="w-100 mb-2">
            <slot />
        </div>

        <div class="card card-body border-0 bg-transparent py-0 d-flex flex-row justify-content-center align-items-end">
            <div class="me-auto">
                <SelectForm @hasChange="changeOrder" label="Ordem:"
                    :options="this.$parent.orders" v-model="theIndex" />
            </div>
            <ButtonConfirmationUi @hasConfirmed="deleteConfirm" confirmText="Certeza?"
                variant="danger" icon="trash" outlined />
        </div>
    </div>

</template>

<script>

import SelectForm from '../../Form/SelectForm.vue';
import ButtonConfirmationUi from '../../Ui/ButtonConfirmationUi.vue';

export default {
    components: { ButtonConfirmationUi, SelectForm },
    props: {
        index: { type: Number, default: 0 }
    },
    emits: { 'changeOrder': null, 'deleteConfirm': null },
    data() {
        return {
            theIndex: this.index
        };
    },
    methods: {
        changeOrder(e) {
            this.$emit('changeOrder', {
                event: e,
                currentIndex: this.index,
                newIndex: parseInt(e.target.value)
            });

            e.target.value = this.index;
        },
        deleteConfirm(e) {
            this.$emit('deleteConfirm', {
                event: e,
                currentIndex: this.index,
            });
        }
    }
}

</script>