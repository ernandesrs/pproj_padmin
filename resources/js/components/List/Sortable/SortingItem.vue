<template>

    <div class="card my-3">
        <div class="card-body d-flex">
            <div class="w-100">
                <slot />
            </div>

            <div class="d-flex flex-column ms-3">
                <div class="mb-2">
                    <SelectForm @hasChange="changeOrder" label="Ordem:"
                        :options="this.$parent.orders" v-model="theIndex" />
                </div>
                <ButtonConfirmationUi @hasConfirmed="deleteConfirm" text="Excluir" confirmText="Certeza?"
                    variant="danger" icon="trash" full size="sm" />
            </div>
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